<?php
/**
 * EasyWeb SmsNotify
 *
 *
 * @category    Easyweb
 * @package     Easyweb_Core
 * @copyright   Copyright (c) 2014 EasyWeb. (http://easyweb.org.ua)
 */

class Easyweb_Smsnotify_Model_Source_Provider extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('easyweb_smsnotify')->__('Please select'),
                    'value' => ''
                ),
                array(
                    'label' => Mage::helper('easyweb_smsnotify')->__('Turbosms'),
                    'value' => 'turbosms'
                ),
                array(
                    'label' => Mage::helper('easyweb_smsnotify')->__('eSputnik'),
                    'value' => 'esputnik'
                ),

            );
        }
        return $this->_options;
    }

    /**
     * Get all options as key=>value array
     * @return array
     */
    public function getOptionsForFilter()
    {
        $options = $this->getAllOptions();
        $result = array();
        foreach ($options as $option) {
            $result[$option['value']] = $option['label'];
        }
        return $result;
    }

    public function toOptionArray()
    {
        return $this->getOptionsForFilter();
    }
}
