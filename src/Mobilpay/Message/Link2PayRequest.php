<?php

namespace Omnipay\MobilPay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MobilPay\Api\Request\SoapRequestTrait;
use Omnipay\MobilPay\Exception\MissingKeyException;

/**
 * MobilPay Purchase Request
 */
class Link2PayRequest extends AbstractRequest
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
        $this->validate('amount', 'currency', 'orderId', 'confirmUrl', 'returnUrl', 'details');

        $envKey    = $envData = null;
        $publicKey = $this->getParameter('publicKey');

        if ( ! $publicKey) {
            throw new MissingKeyException("Missing public key path parameter");
        }

        $req = new \stdClass();

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

        $req->account = $account;
        $req->order   = $order;

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
        $soap = new \SoapClient($this->getEndpoint(), ['cache_wsdl' => WSDL_CACHE_NONE]);

        try {
            $this->response = $soap->doPay(['request' => $data]);
//            if (isset($this->response->doPayResult->errors) && $this->response->errors->code != ERR_CODE_OK) {
//                throw new \Exception($this->response->code, $this->response->message);
//            }
            return $this->response;
        } catch (\SoapFault $e) {
            throw new \Exception($e->faultstring);//, $e->faultcode, $e);
        }
    }
}
