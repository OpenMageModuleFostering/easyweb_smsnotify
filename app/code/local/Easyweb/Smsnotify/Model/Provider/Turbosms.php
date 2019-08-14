<?php
/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */

class Easyweb_Smsnotify_Model_Provider_Turbosms extends Easyweb_Smsnotify_Model_Provider_Abstract
{
    /**
     * Prefix of provider
     * @var string
     */
    protected $_prefix = 'turbosms';

    /**
     * Api url
     * @var string
     */
    protected $_url = 'http://turbosms.in.ua/api/wsdl.html';

    /**
     * Create client
     *
     * @return SoapClient
     */
    protected function _getClient()
    {
        if (is_null($this->_client)) {
            $this->_client = new SoapClient ($this->_url);
        }
        return $this->_client;
    }

    /**
     * Auth client on provider side
     *
     * @return SoapClient
     */
    protected function _getAuthClient()
    {
        $login = $this->getConfigField('login');
        $password = $this->getConfigField('password');

        $auth = array(
            'login' => $login,
            'password' => $password
        );

        $auth = $this->_getClient()->Auth($auth);
        $this->_addErrorMessage($auth->AuthResult);

        return $this->_getClient();
    }

    /**
     * Send sms when order is placed
     *
     * @param string $orderId
     * @param float $amount
     * @return array
     */
    public function sendOrderSms($orderId, $amount)
    {
        $sms = array(
            'sender' => $this->getSender(),
            'destination' => $this->getStorePhone(),
            'text' => $this->getTextMessage($orderId, $amount),
        );
        $result = $this->_getAuthClient()->sendSMS($sms);
        if (!is_array($result->SendSMSResult->ResultArray)) {
            $message = $result->SendSMSResult->ResultArray;
            $this->_addErrorMessage($message)->_logMessages();
        }
        return;
    }
}
