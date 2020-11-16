<?php

namespace Omnipay\MobilPay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MobilPay\Api\Request\SoapRequestTrait;
use Omnipay\MobilPay\Exception\MissingKeyException;

/**
 * MobilPay Purchase Request
 */
class RecurrentPaymentRequest extends AbstractRequest
{
    use SoapRequestTrait;

    /**
     * Build encrypted request data
     *
     * @return \stdClass
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @throws \Omnipay\MobilPay\Exception\MissingKeyException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'orderId', 'confirmUrl', 'details', 'paymentToken');

        $envKey    = $envData = null;
        $publicKey = $this->getParameter('publicKey');

        if ( ! $publicKey) {
            throw new MissingKeyException("Missing public key path parameter");
        }

        $req = new \stdClass();

        $transaction               = new \stdClass();
        $transaction->paymentToken = $this->getPaymentToken(); //you will receive this token together with its expiration date following a standard payment. Please store and use this token with maximum care

        $account              = new \stdClass();
        $account->id          = $this->getMerchantId();
        $account->user_name   = $this->getUsername(); //please ask mobilPay to upgrade the necessary access required for token payments
        $account->customer_ip = $this->getClientIp(); //the IP address of the buyer.
        $account->confirm_url = $this->getConfirmUrl(); //this is where mobilPay will send the payment result. This has priority over the SOAP call response


        $total = $this->getAmount();
        $total = rtrim((strpos($total, ".") !== false ? rtrim($total, "0") : $total), ".");
        $total = strpos($total, '.') ? (float)$total : (int)$total;

        $order              = new \stdClass();
        $order->id          = $this->getOrderId();
        $order->description = $this->getDetails();
        $order->amount      = $total;
        $order->currency    = $this->getCurrency();
        $order->billing     = $this->getBillingAddress();

        $account->hash = strtoupper(sha1(strtoupper(md5($this->getPassword())).$this->getOrderId().$total.$this->getCurrency().$this->getMerchantId()));

        $req->account     = $account;
        $req->order       = $order;
        $req->transaction = $transaction;

        return $req;
    }

    /**
     * @param  array  $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \SoapFault
     * @throws \Exception
     */
    public function sendData($data)
    {
        $soap = $this->getSoapClient();

        try {
            $this->response = $soap->doPayT(['request' => $data]);

            return $this->response;
        } catch (\SoapFault $e) {
            throw new \Exception($e->faultstring);//, $e->faultcode, $e);
        }
    }
}
