<?php
/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */

abstract class Easyweb_Smsnotify_Model_Provider_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Prefix of provider
     * @var string
     */
    protected $_prefix;

    /**
     * Login for webservice
     * @var string
     */
    protected $_login;

    /**
     * Password for webservice
     * @var string
     */
    protected $_password;

    /**
     * @var SoapClient
     */
    protected $_client = null;

    protected $_messages = array('Easyweb SMS Notify');

    abstract public function sendOrderSms($orderId, $amount);

    /**
     * Get field with provider prefix
     *
     * @param string $field
     * @return string|null
     */
    public function getConfigField($field)
    {
        $value = Mage::getStoreConfig('easywebsmsnotify/general/' . $this->_prefix . '_' . $field);
        return $value ? $value : null;
    }

    /**
     * Get text for sms
     *
     * @param string $orderId
     * @param float $amount
     * @return string
     */
    public function getTextMessage($orderId, $amount)
    {
        $text = Mage::helper('easyweb_smsnotify')->getTextMessage();
        $text = iconv('windows-1251', 'utf-8', $text);
        return str_replace(
            array('%ORDER_ID%', '%AMOUNT%'),
            array($orderId, $amount),
            $text
        );
    }

    /**
     * Get destination number for sms
     *
     * @return string
     */
    public function getStorePhone()
    {
        return Mage::helper('easyweb_smsnotify')->getStorePhone();
    }

    /**
     * Log error messages
     *
     * @return $this
     */
    protected function _logMessages()
    {
        Mage::log(implode("\n", $this->_messages));
        return $this;
    }

    /**
     * Add error message
     *
     * @param $message
     * @return $this
     */
    protected function _addErrorMessage($message)
    {
        $this->_messages[] = $message;
        return $this;
    }

    /**
     * Get sender
     *
     * @return null|string
     */
    public function getSender()
    {
        return $this->getConfigField('sender');
    }
}
