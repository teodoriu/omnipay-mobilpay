<?php

namespace Omnipay\MobilPay\Api\Request;

use Omnipay\MobilPay\Api\Address;

/**
 * MobilPay Purchase Request
 */
trait SoapRequestTrait
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://sandbox.mobilpay.ro/api/payment/?wsdl';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://secure.mobilpay.ro/api/payment2/?wsdl';

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * @return string
     */
    public function getConfirmUrl()
    {
        return $this->getParameter('confirmUrl');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setConfirmUrl($value)
    {
        return $this->setParameter('confirmUrl', $value);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->getParameter('params');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setParams($value)
    {
        return $this->setParameter('params', $value);
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->getParameter('details');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setDetails($value)
    {
        return $this->setParameter('details', $value);
    }

    /**
     * @return mixed
     */
    public function getRecurrence()
    {
        return $this->getParameter('recurrence');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setRecurrence($value)
    {
        return $this->setParameter('recurrence', $value);
    }

    /**
     * @return mixed
     */
    public function getPaymentNo()
    {
        return $this->getParameter('paymentNo');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setPaymentNo($value)
    {
        return $this->setParameter('paymentNo', $value);
    }

    /**
     * @return mixed
     */
    public function getIntervalDay()
    {
        return $this->getParameter('intervalDay');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setIntervalDay($value)
    {
        return $this->setParameter('intervalDay', $value);
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->getParameter('billingAddress');
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setBillingAddress($value)
    {
        $this->setParameter('billingAddress', $value);
    }

    /**
     * @return array
     */
    public function getShippingAddress()
    {
        return $this->getParameter('shippingAddress');
    }

    /**
     * @param  array  $value
     */
    public function setShippingAddress($value)
    {
        $this->setParameter('shippingAddress', $value);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param  string  $value
     */
    public function setUsername($value)
    {
        $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param  string  $value
     */
    public function setPassword($value)
    {
        $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->getParameter('sessionId');
    }

    /**
     * @param  string  $value
     */
    public function setSessionId($value)
    {
        $this->setParameter('sessionId', $value);
    }

    /**
     * @return string
     */
    public function getSacId()
    {
        return $this->getParameter('sacId');
    }

    /**
     * @param  string  $value
     */
    public function setSacId($value)
    {
        $this->setParameter('sacId', $value);
    }


    /**
     * @param  array  $parameters
     *
     * @return Address
     */
    public function makeBillingAddress(array $parameters = [])
    {
        $address = new Address();

        $address->type           = $parameters['type']; // person or company
        $address->firstName      = $parameters['firstName'];
        $address->lastName       = $parameters['lastName'];
        $address->fiscalNumber   = $parameters['fiscalNumber'];
        $address->identityNumber = $parameters['identityNumber'];
        $address->country        = $parameters['country'];
        $address->county         = $parameters['county'];
        $address->city           = $parameters['city'];
        $address->zipCode        = $parameters['zipCode'];
        $address->address        = $parameters['address'];
        $address->email          = $parameters['email'];
        $address->mobilePhone    = $parameters['mobilePhone'];
        $address->bank           = $parameters['bank'];
        $address->iban           = $parameters['iban'];

        return $address;
    }

    /**
     * @param  array  $parameters
     *
     * @return Address
     */
    public function makeShippingAddress(array $parameters = [])
    {
        return $this->makeBillingAddress($parameters);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
