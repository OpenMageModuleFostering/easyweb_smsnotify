<?php

/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */
class Easyweb_Smsnotify_Model_Provider_Esputnik extends Easyweb_Smsnotify_Model_Provider_Abstract
{
    /**
     * Prefix of provider
     * @var string
     */
    protected $_prefix = 'esputnik';

    /**
     * Api url
     * @var string
     */
    protected $_urlSendSms = 'http://esputnik.com.ua/api/v1/message/sms';
    protected $_urlBalance = 'http://esputnik.com.ua/api/v1/balance';

    /**
     * @return resource
     */
    protected function _getAuthCurlObject()
    {
        $login = $this->getConfigField('login');
        $password = $this->getConfigField('password');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return $ch;
    }

    /**
     * @param $ch
     * @return mixed
     */
    protected function _getResponse($ch)
    {
        $output = curl_exec($ch);
        if ($output === FALSE) {
            $this->_addErrorMessage($ch);
        } else {
            return $output;
        }
        curl_close($ch);

        return false;
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
        $json_value = new stdClass();
        $json_value->text = $this->getTextMessage($orderId, $amount);
        $json_value->from = $this->getSender();
        $json_value->phoneNumbers = array($this->getStorePhone());

        $ch = $this->_getAuthCurlObject();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
        curl_setopt($ch, CURLOPT_URL, $this->_urlSendSms);
        return $this->_getResponse($ch);
    }

    /**
     * @return mixed
     */
    public function checkBalance()
    {
        $ch = $this->_getAuthCurlObject();
        curl_setopt($ch, CURLOPT_URL, $this->_urlBalance);
        $response = $this->_getResponse($ch);

        $response = json_decode($response);

        $output = $response->currentBalance . ' ' . $response->currency;
        if ($response->bonusSmses) {
            $output .= '<br />(Bonus SMS: ' . $response->bonusSmses . ')';
        }


        return $output;
    }
}
