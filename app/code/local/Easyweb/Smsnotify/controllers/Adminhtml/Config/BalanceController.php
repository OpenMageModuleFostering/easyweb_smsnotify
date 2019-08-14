<?php

/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */
class Easyweb_Smsnotify_Adminhtml_Config_BalanceController extends Mage_Adminhtml_Controller_Action
{
    protected function _checkBalance()
    {
        $helper = Mage::helper('easyweb_smsnotify');

        $providerModel = $helper->getProviderModel();
        if ($providerModel) {
            return $providerModel->checkBalance();
        }
        return 0;
    }

    /**
     * Check whether vat is valid
     *
     * @return void
     */
    public function checkAction()
    {
        $result = $this->_checkBalance();
        $this->getResponse()->setBody($result);
    }
}
