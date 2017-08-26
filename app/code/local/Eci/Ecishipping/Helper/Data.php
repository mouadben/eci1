<?php

class Eci_Ecishipping_Helper_Data extends Mage_Core_Helper_Abstract
{

    const TAX_FIELD_SUFFIX_07 = '_mwstl';
    const TAX_FIELD_SUFFIX_19 = '_mwsth';

    const TAX_LOW_PERCENT = 7;

    public function allowManuallyPrice()
    {
        return Mage::getSingleton('admin/session')->isAllowed('ogcore/ecishipping/manually_price');
    }

    public function getTaxFieldSuffix($items = null)
    {

        /** @var Mage_Sales_Model_Quote_Item_Abstract $item */
        if ($items) {
            $lowTax = true;
            foreach ($items as $item) {
                if (intval($item->getData('tax_percent')) > self::TAX_LOW_PERCENT) {
                    $lowTax = false;
                    break;
                }
            }

            return ($lowTax) ? self::TAX_FIELD_SUFFIX_07 : self::TAX_FIELD_SUFFIX_19;
        }

        return self::TAX_FIELD_SUFFIX_19;
    }

}
