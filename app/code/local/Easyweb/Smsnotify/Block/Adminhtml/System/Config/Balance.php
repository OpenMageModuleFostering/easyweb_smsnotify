<?php
/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Smsnotify
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */

class Easyweb_Smsnotify_Block_Adminhtml_System_Config_Balance extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Set template to itself
     *
     * @return Mage_Adminhtml_Block_Customer_System_Config_Validatevat
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('smsnotify/system/config/balance.phtml');
        }
        return $this;
    }

    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(array(
            'button_label' => Mage::helper('easyweb_smsnotify')->__($originalData['button_label']),
            'html_id' => $element->getHtmlId(),
            'ajax_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/config_balance/check')
        ));

        return $this->_toHtml();
    }
}
