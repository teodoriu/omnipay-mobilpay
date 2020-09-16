<?php

namespace Omnipay\MobilPay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MobilPay\Api\Request\SoapRequestTrait;
use Omnipay\MobilPay\Exception\MissingKeyException;

/**
 * MobilPay Purchase Request
 */
class CreditRequest extends AbstractRequest
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
        $this->validate('sessionId', 'sacId', 'merchantId', 'amount');

        $envKey    = $envData = null;
        $publicKey = $this->getParameter('publicKey');

        if ( ! $publicKey) {
            throw new MissingKeyException("Missing public key path parameter");
        }

        $req = new \stdClass();

        $total = $this->getAmount();
        $total = rtrim((strpos($total, ".") !== false ? rtrim($total, "0") : $total), ".");
        $total = stripos($total, '.') ? (float)$total : (int)$total;

        $req->sessionId = $this->getSessionId();
        $req->sacId     = $this->getSacId();
        $req->orderId   = $this->getOrderId();
        $req->amount    = $total;

        return $req;
    }

    /**
     * @param  array  $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     * @throws \SoapFault
     * @throws \Exception
     */
    public function sendData($data)
    {
        $soap = $this->getSoapClient();

        try {
            $this->response = $soap->credit(['request' => $data]);

            return $this->response;
        } catch (\SoapFault $e) {
            throw new \Exception($e->faultstring);//, $e->faultcode, $e);
        }
    }
}
