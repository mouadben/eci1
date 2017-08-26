<?php

class Eci_Ecishipping_Model_Sales_Order extends Mage_Core_Model_Abstract
{


    const STATUS_MANUALLY_PRICE_NO = 0;
    const STATUS_MANUALLY_PRICE_YES = 1;
    const XML_PATH_COD_METHOD = 'carriers/ecishipping/cod_method';
    //const XML_PATH_COD_TOUR = 'carriers/ecishipping/cod_tour';


    protected function _construct()
    {

        $this->_init('ecishipping/sales_order');
    }


    public function loadByQouteId($quoteId)
    {

        try {
            $this->load($quoteId, 'quote_id');

            if (!$this->getQuoteId()) {
                $this->setQuoteId($quoteId);
                $this->save();
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }


    public function loadByOrderId($id)
    {

        return $this->load($id, 'order_id');
    }


    /**
     * Handling for frontend
     *
     * @param $quote
     * @return Eci_Ecishipping_Model_Sales_Order
     */
    public function updateFromQuote($quote)
    {

        $shippingDate = Mage::app()->getRequest()->getParam('shipping_date');
        $deliveryDate = Mage::app()->getRequest()->getParam('delivery_date');
        $onestepdeliveryDate = Mage::app()->getRequest()->getParam('delivery')['onestepcheckout-date'];
        if($onestepdeliveryDate){
            $deliveryDate = $onestepdeliveryDate;
        }

        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if($shippingMethod == 'upsaccesspoint_upsaccesspoint'){
            $grandTotal = $quote->getGrandTotal();
            if($grandTotal < 150){
                $shippingMethod = 'ecishipping_299';
            }else{
                $shippingMethod = 'ecishipping_300';
            }
        }

        $method = Mage::getModel('ecishipping/method')->loadByShippingMethodCode($shippingMethod);

        if ($method->getId()) {

            $method->loadStoreLabels($quote->getStoreId());

            $this->loadByQouteId($quote->getId());
            $this->setData('quote_id', $quote->getId());
            $this->setData('method_id', $method->getId());
            $this->setData('items', $method->getItemCollection());
            /*$this->setData('tour', $method->getTour());*/
            $this->setData('shipping_amount', $method->getCost());
            $this->setData('carrier_label', $method->getCarrierLabel($quote->getStoreId()));
            $this->setData('method_label', $method->getTitle());
            $this->setData('tax_field_suffix', Mage::helper('ecishipping')->getTaxFieldSuffix($quote->getAllItems()));

            if ($shippingDate) {
                $this->setData('shipping_date', $shippingDate);
            }

            if ($deliveryDate) {
                $this->setData('delivery_date', $deliveryDate);
            }

            $this->save();
        } else {
            if($shippingMethod == 'upsaccesspoint_upsaccesspoint'){
                $method->loadStoreLabels($quote->getStoreId());

                $this->loadByQouteId($quote->getId());
                $this->setData('quote_id', $quote->getId());
                $this->setData('method_id', $method->getId());
                $this->setData('items', $method->getItemCollection());
                /*$this->setData('tour', $method->getTour());*/
                $this->setData('shipping_amount', $method->getCost());
                $this->setData('carrier_label', $method->getCarrierLabel($quote->getStoreId()));
                $this->setData('method_label', $method->getTitle());
                $this->setData('tax_field_suffix', Mage::helper('ecishipping')->getTaxFieldSuffix($quote->getAllItems()));
                if ($shippingDate) {
                    $this->setData('shipping_date', $shippingDate);
                }

                if ($deliveryDate) {
                    $this->setData('delivery_date', $deliveryDate);
                }

                $this->save();
            }
            else{
                $this->loadByQouteId($quote->getId());

                if ($this->getId()) {
                    $this->delete();
                }

                $this->setData(array());
            }

        }

        return $this;
    }


    /**
     * Set order id on order save
     *
     * @param $order
     * @return Eci_Ecishipping_Model_Sales_Order
     */
    public function updateFromOrder($order)
    {
        /* use load by order because order exists and to avoid constraint violation*/
        $this->loadByQouteId($order->getQuoteId());
        //$this->loadByOrderId($order->getId());

        if ($this->getId()) {
            $this->setOrderId($order->getId());
            $this->save();
        }

        return $this;
    }


    /**
     * Handle on adminhtml editing
     *
     * @param $orderCreateModel
     * @param $requestModel
     * @param $session
     */
    public function updateFromCreate($orderCreateModel, $requestModel, $session)
    {

        $postData = $requestModel->getParam('ecishipping');

        if (is_array($postData)) {

            $quoteId = $session->getQuote()->getId();
            $this->loadByQouteId($quoteId);

            $ecishippingInfo = new Varien_Object($postData);

            if ($ecishippingInfo->hasData('manual')) {
                $this->setManual($ecishippingInfo->getManual());

                if ($this->getManual()) {
                    $this->setMethodId(null);
                } else {
                    $this->setCarrierLabel(null);
                    $this->setMethodLabel(null);
                    $this->setTour(null);
                    $this->setManuallyPrice(self::STATUS_MANUALLY_PRICE_NO);
                }

                $this->save();
            } else {

                $shippingDate = $ecishippingInfo->getShippingDate();
                $deliveryDate = $ecishippingInfo->getDeliveryDate();

                $filterInput = new Zend_Filter_LocalizedToNormalized(array('date_format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)));
                $shippingDate = $filterInput->filter($shippingDate);
                $filterInternal = new Zend_Filter_NormalizedToLocalized(array('date_format' => Varien_Date::DATE_INTERNAL_FORMAT));
                $shippingDate = $filterInternal->filter($shippingDate);
                $shippingDate = $shippingDate ? $shippingDate : null;

                $filterInput = new Zend_Filter_LocalizedToNormalized(array('date_format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)));
                $deliveryDate = $filterInput->filter($deliveryDate);
                $filterInternal = new Zend_Filter_NormalizedToLocalized(array('date_format' => Varien_Date::DATE_INTERNAL_FORMAT));
                $deliveryDate = $filterInternal->filter($deliveryDate);
                $deliveryDate = $deliveryDate ? $deliveryDate : null;

                $this->setShippingDate($shippingDate);
                $this->setDeliveryDate($deliveryDate);

                $this->setDefaultDates($session->getQuote());

                $this->setTour($ecishippingInfo->getTour());

                if ($this->getManual()) {

                    $this->setTour($ecishippingInfo->getTour());
                    $this->setCarrierLabel($ecishippingInfo->getCarrierLabel());
                    $this->setMethodLabel($ecishippingInfo->getMethodLabel());

                    if ($ecishippingInfo->getItem()) {
                        if ($ecishippingInfo->getItemStatus()) {
                            $item = Mage::getModel('ecishipping/item')->load($ecishippingInfo->getItem());
                            $this->addItem($item);
                        } else {
                            $this->removeItem($ecishippingInfo->getItem());
                        }
                    }

                    if (Mage::helper('ecishipping')->allowManuallyPrice() && $ecishippingInfo->getManuallyPriceCheckbox()) {
                        $this->setManuallyPrice(self::STATUS_MANUALLY_PRICE_YES);
                        $this->setShippingAmount($ecishippingInfo->getShippingAmount());
                    } else {
                        $this->setManuallyPrice(self::STATUS_MANUALLY_PRICE_NO);
                    }
                } else {
                    if ($ecishippingInfo->hasData('method')) {
                        $method = Mage::getModel('ecishipping/method')->load($ecishippingInfo->getMethod());
                        if ($method->getId()) {

                            $this->setMethodId($method->getId());
                            $this->setTour($method->getTour());
                            $this->setCarrierLabel($method->getCarrierLabel());
                            $this->setMethodLabel($method->getTitle());

                            $this->removeItems();

                            foreach ($method->getItemCollection() as $item) {
                                $this->addItem($item);
                            }
                        } else {
                            $this->setMethodId(null);
                        }
                    }
                }
            }

            $this->setData('tax_field_suffix', Mage::helper('ecishipping')->getTaxFieldSuffix($session->getQuote()->getAllItems()));
            if ($this->getData('manually_price') == self::STATUS_MANUALLY_PRICE_NO) {
                $this->save();
                $this->collectCost();
            }

            $this->save();
        }

        return $this;
    }


    public function addItem(Eci_Ecishipping_Model_Item $item)
    {

        $this->getResource()->addItem($this, $item);

        return $this;
    }


    public function removeItem($itemId)
    {

        $this->getResource()->removeItem($this, $itemId);

        return $this;
    }


    public function removeItems()
    {

        $this->getResource()->removeItems($this);

        return $this;
    }


    public function collectCost()
    {

        $cost = $this->getResource()->collectCost($this);
        $this->setShippingAmount($cost);

        return $this;
    }


    public function copy($orderId, $quoteId)
    {

        $this->loadByOrderId($orderId);
        $this->setId(null);
        $this->setOrderId(null);
        $this->setQuoteId($quoteId);
        $this->save();

        return $this;
    }


    public function setDefaultDates(Mage_Sales_Model_Quote $quote)
    {

        $format = 'yyyy-MM-dd';

        $shippingDate = $this->getShippingDate() ? Mage::app()->getLocale()->storeDate()->setDate($this->getShippingDate(), $format) : Mage::app()->getLocale()->storeDate();
        $deliveryDate = $this->getDeliveryDate() ? Mage::app()->getLocale()->storeDate()->setDate($this->getDeliveryDate(), $format) : Mage::app()->getLocale()->storeDate();

        if (!$this->getShippingDate()) {
            if ($this->getDeliveryDate()) {
                $shippingDate = clone $deliveryDate;
                $shippingDate->subDay($this->_getOffsetBack($quote, $deliveryDate));
                $this->setShippingDate($shippingDate->get($format));
            } else {
                $shippingDate = Mage::app()->getLocale()->storeDate();
                $this->setShippingDate($shippingDate->get($format));
            }
        }

        if (!$this->getDeliveryDate()) {
            $deliveryDate = Mage::app()->getLocale()->storeDate();
            $deliveryDate->addDay($this->_getOffset($quote, $shippingDate));
            $this->setDeliveryDate($deliveryDate->get($format));
        }

        return $this;
    }


    public function hasDateError($date, $dateCompare = null)
    {

        $format = 'yyyy-MM-dd';

        if (is_string($dateCompare)) {
            $dateCompare = Mage::app()->getLocale()->storeDate()->setDate($dateCompare, $format);
        } elseif (!($date instanceof Zend_Date)) {
            $dateCompare = Mage::app()->getLocale()->storeDate();
        }

        if (is_string($date)) {
            $date = Mage::app()->getLocale()->storeDate()->setDate($date, $format);
        } elseif (!($date instanceof Zend_Date)) {
            $date = Mage::app()->getLocale()->storeDate();
        }

        if ($date->compareDate($dateCompare) < 0) {
            return true;
        }

        return false;
    }


    protected function _getOffset(Mage_Sales_Model_Quote $quote, $date)
    {

        /** @var Mage_Sales_Model_Quote_Address */
        $address = $quote->getShippingAddress();

        /** determine shipping address offset */
        $offset = $address->getShippingOffset();
        $offset = intval($offset);

        /** determine region offset */
        if ($offset < 0) {
            //$offset = Mage::getResourceModel('ecishipping/offset')->getDeliveryTime($address->getCountry(), $address->getRegionCode(), $address->getPostcode(), false, false);
            $offset = Mage::getResourceModel('ogsource/option')->getShippingTime($address->getShippingMethod()->getTour());
            $offset = intval($offset);
        }

        /** determine default offset */
        if ($offset < 0) {
            $offset = Mage::getStoreConfig(Eci_Ecishipping_Block_Carrier_Form::XML_PATH_CARRIERS_OSHIP_DAYSOFFSET);
            $offset = intval($offset);
        }

        if ($offset < 0) {
            $offset = 1;
        }

        return $offset;
    }


    protected function _getOffsetBack(Mage_Sales_Model_Quote $quote, $date)
    {

        /** @var Mage_Sales_Model_Quote_Address */
        $address = $quote->getShippingAddress();

        $offset = $address->getShippingOffset();
        // $offset = $offset ? $offset : Mage::getStoreConfig(Eci_Ecishipping_Block_Carrier_Form::XML_PATH_CARRIERS_OSHIP_DAYSOFFSET);
        //$offset = $offset ? $offset : Mage::getResourceModel('ecishipping/offset')->getDeliveryTime($address->getCountry(), $address->getRegionCode(), $address->getPostcode(), false, false);
        $offset = $offset ? $offset : Mage::getResourceModel('ogsource/option')->getShippingTime($address->getShippingMethod()->getTour());
        return Mage::getModel('ecishipping/offset')->getDeliveringTimeBack($offset, clone $date);
    }
}
