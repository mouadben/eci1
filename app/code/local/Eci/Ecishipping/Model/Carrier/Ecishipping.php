<?php

class Eci_Ecishipping_Model_Carrier_Ecishipping extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{

    const CODE = 'ecishipping';


    public function __construct()
    {
        parent::__construct();
        $this->_code = self::CODE;
    }


    /**
     * @return Mage_Shipping_Model_Rate_Request
     */
    public function getRequest()
    {
        return $this->getData('request');
    }


    /**
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return type
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $this->setRequest($request);
        $result = Mage::getModel('shipping/rate_result');

        foreach ($this->getAllowedOgMethods() as $ecishippingMethod) {
            $taxFieldSuffix = Mage::helper('ecishipping')->getTaxFieldSuffix($request->getAllItems());
            $cost = $ecishippingMethod->getCost($taxFieldSuffix);
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_getCode());
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethodId($ecishippingMethod->getId());
            $method->setMethod($ecishippingMethod->getCode());
            $method->setMethodTitle($ecishippingMethod->getTitle());
            $method->setCost($cost);
            $method->setPrice($cost);
            $method->setMethodDescription($ecishippingMethod->getDescription());
            $result->append($method);
        }
        return $result;
    }

    public function getAllowedMethods()
    {
        $methods = array();
        foreach ($this->getAllowedOgMethods() as $method) {
            $methods[$method->getCode()] = $method->getTitle();
        }
        return $methods;
    }

    public function getAllowedOgMethods()
    {
        $methods = Mage::getModel('ecishipping/method')->getCollection();
        $methods->addFieldToFilter('is_active', Eci_Ecishipping_Model_Method::ACTIVE_YES);
        if ($this->getRequest()) {
            foreach ($methods as $key => $method) {
                 /***  remove methods not allowed for website*/
                if (!in_array($this->getRequest()->getWebsiteId(), $method->getWebsite())) {
                    $methods->removeItemByKey($key);
                }
                /***  remove methods not allowed for country */
                if ($method->getCountrySpecific() && !in_array($this->getRequest()->getDestCountryId(), $method->getCountry())) {
                    $methods->removeItemByKey($key);
                }
                /**  remove methods not allowed for plz */
                /*$erlaubte_touren=Mage::getResourceModel('ogsource/option')->getAllowedTours($this->getRequest()->getDestPostcode());
                if(!in_array($method->getTour(),$erlaubte_touren)){
                    $methods->removeItemByKey($key);
                }*/
                /**  remove methods not allowed for customer group */
                if($method->getCustomerGroupSpecific()&&!in_array(Mage::getSingleton('customer/session')->getCustomerGroupId(), $method->getCustomerGroup())){
                    $methods->removeItemByKey($key);
                }
                /**  remove methods not allowed for Skus */
                if($method->getSkuFilter()){
                    $skuErlaubt = $this->_getSkuErlaubt($method->getSkuListe());
                    if(!$skuErlaubt){
                        $methods->removeItemByKey($key);
                    }
                }
                /** remove methods not allowed for package value */
                if ($method->getThresholdType()) {


                    //$packageValue = $this->getRequest()->getPackageValue();
                    //$packageValue = $this->getRequest()->getBaseSubtotalInclTax();
                    $packageValue = $this->getTotalInkTax($this->getRequest()->getAllItems());

                    $thresholdValue = $method->getThresholdValue();
                    $thresholdValueSecond = $method->getThresholdValueSecond();

                    switch ($method->getThresholdType()) {
                        case Eci_Ecishipping_Model_Method::THRESHOLD_LT :
                            $check = ($packageValue < $thresholdValue);
                            break;
                        case Eci_Ecishipping_Model_Method::THRESHOLD_LTEQ :
                            $check = ($packageValue <= $thresholdValue);
                            break;
                        case Eci_Ecishipping_Model_Method::THRESHOLD_EQ :
                            $check = ($packageValue == $thresholdValue);
                            break;
                        case Eci_Ecishipping_Model_Method::THRESHOLD_GTEQ :
                            $check = ($packageValue >= $thresholdValue);
                            break;
                        case Eci_Ecishipping_Model_Method::THRESHOLD_GT :
                            $check = ($packageValue > $thresholdValue);
                            break;
                        case Eci_Ecishipping_Model_Method::THRESHOLD_GT_AND_LESS :
                            $check = ($packageValue > $thresholdValue && $packageValue < $thresholdValueSecond);
                            break;
                        default :
                            $check = false;
                    }

                    if (!$check) {
                        $methods->removeItemByKey($key);
                    }
                }
            }

            $itemsWarenGroups= $this->_getItemsWarenGroups();
            $quoteId = $this->_getQuoteId();
            $quote = Mage::getModel('sales/quote')->load($quoteId);
            $auftragsRabatId = $quote->getAppliedRuleIds();
            $methodsTemp = clone $methods;
            if ($itemsWarenGroups) {
                foreach ($methodsTemp as $key => $method) {
                    $passende_kategorie = $method->getData('exclusive_category');
                    if($passende_kategorie){
                        foreach($itemsWarenGroups as $item_group) {
                            if(!in_array($item_group,$passende_kategorie)) {
                                $methodsTemp->removeItemByKey($key);
                            }
                        }
                    }else{
                        $methodsTemp->removeItemByKey($key);
                    }
                }
                if ($methodsTemp->count()) {
                    $methodsTemp;
                }else{
                    $methodsTemp = clone $methods;
                    foreach ($methodsTemp as $key => $method) {
                        if ($method->getData('exclusive_category')) {
                            $methodsTemp->removeItemByKey($key);
                        }
                    }
                    if ($methodsTemp->count()) {
                        $methodsTemp;
                    }
                }
            }else{
                foreach ($methodsTemp as $key => $method) {
                    if ($method->getData('exclusive_category')) {
                        $methodsTemp->removeItemByKey($key);
                    }
                }
            }
            if($auftragsRabatId){
                $methodsTempI = clone $methodsTemp;
                foreach ($methodsTempI as $key => $method) {
                    if($method->getData('auftragsrabat_filter') && $method->getData('auftragsrabat_id')){
                        $array =  explode(',', $method->getData('auftragsrabat_id'));
                        if (!in_array($auftragsRabatId,$array)) {
                            $methodsTempI->removeItemByKey($key);
                        }
                    }else{
                        $methodsTempI->removeItemByKey($key);
                    }
                }
                if(!$methodsTempI->count()){
                    foreach ($methodsTemp as $key => $method) {
                        if ($method->getData('auftragsrabat_filter')) {
                            $methodsTemp->removeItemByKey($key);
                        }
                    }
                    return $methodsTemp;
                }else{
                    return $methodsTempI;
                }
            }else{
                foreach ($methodsTemp as $key => $method) {
                    if ($method->getData('auftragsrabat_filter')) {
                        $methodsTemp->removeItemByKey($key);
                    }
                }
                return $methodsTemp;
            }
        }
        return $methods;
    }

    protected function _getSkuErlaubt($skuListe){
        if ($this->getRequest()) {
            foreach ($this->getRequest()->getAllItems() as $item) {
                if(strpos($skuListe,"*".$item->getSku()."*")!==false){
                    return true;
                }
            }
            return false;
        }
    }

    protected function _getItemsWarenGroups()
    {
        $warenGroups = array();
        if ($this->getRequest()) {
            foreach ($this->getRequest()->getAllItems() as $item) {
                $csbWarengruppe = Mage::getResourceModel('catalog/product')
                    ->getAttributeRawValue($item->getProductId(), 'csb_warengruppe', Mage::app()->getStore());
                if ($csbWarengruppe) {
                    $warenGroups[] =$csbWarengruppe;
                }
            }
        }
        if(count($warenGroups)){
            return $warenGroups;
        }else{
            return false;
        }
    }
    protected function _getQuoteId()
    {
        foreach ($this->getRequest()->getAllItems() as $item) {
            $quoteId = $item->getQuoteId();
            if($quoteId){
                return $quoteId;
            }
        }
        return false;
    }

    protected function _getCode()
    {
        return self::CODE;
    }
    protected function getTotalInkTax($allItems){
        $total=0;
        foreach($allItems as $item){
            $total+= $item->getData('row_total_incl_tax');
        }
        return $total;
    }
}
