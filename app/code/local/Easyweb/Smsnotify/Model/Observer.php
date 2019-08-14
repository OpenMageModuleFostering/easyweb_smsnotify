<?php

/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */
class Easyweb_Smsnotify_Model_Observer
{
    /**
     * Handler for sales_order_place_after
     *
     * @param Varien_Event_Observer $observer
     * @return boolean
     */
    public function sendNotifyToAdminAfterPlaceOrder($observer)
    {
        $helper = Mage::helper('easyweb_smsnotify');
        $order = $observer->getOrder();

        $orderId = $order->getIncrementId();
        $amount = $order->getGrandTotal();

        $providerModel = $helper->getProviderModel();
        if ($providerModel) {
            $providerModel->sendOrderSms($orderId, $amount);
        }

        return $this;
    }
}
