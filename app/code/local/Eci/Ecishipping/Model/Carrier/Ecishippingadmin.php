<?php

class Eci_Ecishipping_Model_Carrier_Ecishippingadmin extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{

    const CODE = 'ecishippingadmin';

    public function __construct()
    {
        $this->_code = self::CODE;
        parent::__construct();
    }

    /**
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return type 
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (Mage::app()->getStore()->getId() == Mage_Core_Model_App::ADMIN_STORE_ID) {

            $items = $request->getAllItems();
            if (count($items)) {

                $item = $items[0];
                
                $ecishipping = Mage::getModel('ecishipping/sales_order')->loadByQouteId($item->getQuoteId());
                
                $method = Mage::getModel('shipping/rate_result_method');
                $method->setCarrier(self::CODE);
                $method->setCarrierTitle($ecishipping->getCarrierLabel());
                $method->setMethodId(0);
                $method->setMethod(self::CODE);
                $method->setMethodTitle($ecishipping->getMethodLabel());
                $method->setCost($ecishipping->getShippingAmount());
                $method->setPrice($ecishipping->getShippingAmount());

                $result = Mage::getModel('shipping/rate_result');
                $result->append($method);

                return $result;
            }
        }

        return false;
    }

    public function getAllowedMethods()
    {
        return array();
    }

    public function isActive()
    {
        return true;
    }

}
