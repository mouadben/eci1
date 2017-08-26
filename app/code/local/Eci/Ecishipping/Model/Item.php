<?php

class Eci_Ecishipping_Model_Item extends Mage_Core_Model_Abstract
{

    const SURCHARGE_TYPE_STD = 1;
    const SURCHARGE_TYPE_EXPRESS = 2;
    const SURCHARGE_TYPE_SATURDAY = 3;

    
    protected function _construct()
    {
        $this->_init('ecishipping/item');
    }
    
    static public function getSurchargeTypeOptions()
    {
        return array(
            self::SURCHARGE_TYPE_STD => Mage::helper('ecishipping')->__('None'),
            self::SURCHARGE_TYPE_EXPRESS => Mage::helper('ecishipping')->__('Express Surcharge'),
            self::SURCHARGE_TYPE_SATURDAY => Mage::helper('ecishipping')->__('Saturday Surcharge')

        );
    }

}
