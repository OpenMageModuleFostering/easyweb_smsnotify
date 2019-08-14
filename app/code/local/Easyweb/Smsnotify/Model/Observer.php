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

        if (!$helper->isSmsEnabled()) {
            return $this;
        }

        $order = $observer->getOrder();

        $orderId = $order->getIncrementId();
        $amount = $order->getGrandTotal();

        $provider = $helper->getProvider();
        $providerModel = Mage::getModel('easyweb_smsnotify/provider_' . $provider);
        if ($providerModel) {
            $providerModel->sendOrderSms($orderId, $amount);
        }

        return $this;
    }
}
