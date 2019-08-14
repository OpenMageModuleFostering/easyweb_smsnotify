<?php

/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */
class Easyweb_Smsnotify_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_provider = null;

    protected $_text = null;

    protected $_phone = null;

    /**
     * Check if sms notify is enabled
     *
     * @return boolean
     */
    public function isSmsEnabled()
    {
        return Mage::getStoreConfig('easywebsmsnotify/general/enabled');
    }

    /**
     * Get current sms provider
     *
     * @return string
     */
    public function getProvider()
    {
        if (is_null($this->_provider)) {
            $this->_provider = Mage::getStoreConfig('easywebsmsnotify/general/provider');
        }
        return $this->_provider;
    }


    /**
     * @return bool|Mage_Core_Model_Abstract
     */
    public function getProviderModel()
    {
        if (!$this->isSmsEnabled()) {
            return false;
        }
        $provider = $this->getProvider();
        if ($provider) {
            return Mage::getModel('easyweb_smsnotify/provider_' . $provider);
        }
        return false;
    }

    /**
     * Get text for sms
     *
     * @return string
     */
    public function getTextMessage()
    {
        if (is_null($this->_text)) {
            $this->_text = Mage::getStoreConfig('easywebsmsnotify/general/text');
        }
        return $this->_text;
    }

    /**
     * Get text for sms
     *
     * @return string
     */
    public function getStorePhone()
    {
        if (is_null($this->_phone)) {
            $this->_phone = Mage::getStoreConfig('easywebsmsnotify/general/store_phone');
        }
        return $this->_phone;
    }
}
