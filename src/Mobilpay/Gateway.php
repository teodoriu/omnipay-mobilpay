<?php

namespace Omnipay\MobilPay;

use Omnipay\Common\AbstractGateway;

/**
 * MobilPay Gateway
 *
 * @link http://www.mobilpay.ro
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'MobilPay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'merchantId' => null,
            'publicKey'  => null,
            'testMode'   => false,
            'recurrence' => false,
        ];
    }

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
     * @param  string  $value
     *
     * @return mixed
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
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
     * @param  string  $value
     *
     * @return mixed
     */
    public function setConfirmUrl($value)
    {
        return $this->setParameter('confirmUrl', $value);
    }

    /**
     * @return  mixed
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
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function setBillingAddress(array $parameters = [])
    {
        $this->setParameter('billingAddress', $parameters);
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->getParameter('shippingAddress');
    }

    /**
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function setShippingAddress(array $parameters = [])
    {
        $this->setParameter('shippingAddress', $parameters);
    }

    /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    /**
     * Sets the test mode of the request.
     *
     * @param  boolean  $value  True for test mode on.
     *
     * @return $this
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * @param  array  $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\PurchaseRequest::class, $parameters);
    }

    /**
     * @param  array  $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\CompletePurchaseRequest::class, $parameters);
    }

    public function createLink2Pay(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\Link2PayRequest::class, $parameters);
    }

    public function recurrentPayment(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\RecurrentPaymentRequest::class, $parameters);
    }
    
    public function login(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\LoginRequest::class, $parameters);
    }

    public function capture(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\CapureRequest::class, $parameters);
    }

    public function credit(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\MobilPay\Message\CreditRequest::class, $parameters);
    }
}
