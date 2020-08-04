<?php

namespace Omnipay\MobilPay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MobilPay\Api\Request\SoapRequestTrait;
use Omnipay\MobilPay\Exception\MissingKeyException;

/**
 * MobilPay Purchase Request
 */
class LoginRequest extends AbstractRequest
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
        $this->validate('username', 'password');

        $envKey    = $envData = null;
        $publicKey = $this->getParameter('publicKey');

        if ( ! $publicKey) {
            throw new MissingKeyException("Missing public key path parameter");
        }

        $req = new \stdClass();

        $req->username = $this->getUsername();
        $req->password = $this->getPassword();

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
        $soap = new \SoapClient($this->getEndpoint(), ['cache_wsdl' => WSDL_CACHE_NONE]);

        try {
            return $this->response = $soap->login(['request' => $data]);
//            if (isset($response->errors) && $response->errors->code != ERR_CODE_OK) {
//                throw new \Exception($response->code, $response->message);
//            }
        } catch (\SoapFault $e) {
            throw new \Exception($e->faultstring);//, $e->faultcode, $e);
        }
    }
}
