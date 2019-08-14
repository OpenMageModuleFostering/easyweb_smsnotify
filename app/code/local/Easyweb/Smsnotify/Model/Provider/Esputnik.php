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
    protected $_url = 'https://esputnik.com.ua/api/v1/message/sms';


    /**
     * Send sms when order is placed
     *
     * @param string $orderId
     * @param float $amount
     * @return array
     */
    public function sendOrderSms($orderId, $amount)
    {
        $login = $this->getConfigField('login');
        $password = $this->getConfigField('password');

        $json_value = new stdClass();
        $json_value->text = $this->getTextMessage($orderId, $amount);
        $json_value->from = $this->getSender();
        $json_value->phoneNumbers = array($this->getStorePhone());

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        if ($output === FALSE) {
            $this->_addErrorMessage($ch);
        }

        return;
    }
}
