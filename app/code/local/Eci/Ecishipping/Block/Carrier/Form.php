<?php

class Eci_Ecishipping_Block_Carrier_Form extends Mage_Core_Block_Template
{


    const XML_PATH_CARRIERS_OSHIP_DAYSOFFSET = 'carriers/ecishipping/daysoffset';
    const XML_PATH_CARRIERS_OSHIP_DAYSPREORDER = 'carriers/ecishipping/dayspreorder';
    const NO_DATE = '0000-00-00';

    protected $_template = 'ecishipping/carrier/form.phtml';

    protected $_methods = null;
    protected $_dateMethods = null;


    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->_getMethods()) {
            return parent::_toHtml();
        }

        return '';
    }


    /**
     * @return bool|null|object
     */
    protected function _getMethods()
    {
        if ($this->_methods === null) {
            $methodIds = array();
            if (is_array($this->getRates())) {
                foreach ($this->getRates() as $rate) {
                    $methodIds[] = $rate->getMethod();
                }
            }

            $this->_methods = Mage::getModel('ecishipping/method')->getCollection();
            $this->_methods->addFieldToFilter('method_id', array('in' => $methodIds));
            $this->_methods->load();

            if (!$this->_methods->count()) {
                $this->_methods = false;
            }
        }

        return $this->_methods;
    }


    /**
     * @return bool
     */
    public function isFreeShipping()
    {
        if ($this->_getMethods() && $this->_getMethods()->count() == 1 && $this->_getMethods()->getFirstItem()->getFreeship()) {
            return true;
        }

        return false;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Mage::getStoreConfig('carriers/ecishipping/description');
    }

    public function getDeliveryAcceptText()
    {
        return Mage::getStoreConfig('carriers/ecishipping/deliveryaccept');
    }


    /**
     * @return string
     */
    public function getYearRange()
    {
        $from = $this->getStoreDate()->get(Zend_Date::YEAR);
        $to = $this->getStoreDate()->addDay(Mage::getStoreConfig(self::XML_PATH_CARRIERS_OSHIP_DAYSPREORDER))->get(Zend_Date::YEAR);

        return "[{$from}, {$to}]";
    }


    /**
     * @return null
     */
    public function getValue()
    {
        $dateMethods = $this->getDateMethods();
        $allowedDates = array_keys($dateMethods);
        return isset($allowedDates[0]) ? $allowedDates[0] : null;
    }


    /**
     * @return mixed
     */
    public function getDsValue()
    {
        if ($this->getValue() != self::NO_DATE) {
            return Mage::helper('core')->formatDate($this->getValue(), 'medium', false);
        }

        return '-';
    }


    /**
     * @return null
     */
    public function getIfValue()
    {
        return $this->getValue();
    }


    /**
     * @return string
     */
    public function daFormat()
    {
        $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $format = Varien_Date::convertZendToStrFtime($format, true, false);

        return $format;
    }


    /**
     * @return Zend_Date
     */
    public function getStoreDate()
    {
        return Mage::app()->getLocale()->storeDate();
    }


    /**
     * @param bool $asJson
     * @return array|null|string
     */
    public function getDateMethods($asJson = false)
    {
        if ($this->_dateMethods === null) {

            $this->_dateMethods = array();

            $removeExpress = false;

            $noship = Mage::getModel('ecishipping/noship');
            $offset = Mage::getModel('ecishipping/offset');

            $from = $this->getStoreDate();
            $date = $this->getStoreDate();
            $days = Mage::getStoreConfig(self::XML_PATH_CARRIERS_OSHIP_DAYSPREORDER);

            $address = $this->getAddress();
            $country = $address->getCountry();
            $region = $address->getRegionCode();
            $postcode = $address->getPostcode();

            $addressShippingOffset = $address->getData('shipping_offset');

            for ($i = 0; $i < $days; $i++) {

                foreach ($this->_getMethods() as $key => $method) {

                    if ($removeExpress && $method->isExpress()) {
                        $this->_getMethods()->removeItemByKey($key);
                        continue;
                    }

                    if ($method->isAvailableForDay($date)) {

                        if ($noship->isPossible($date, $country, $region)) {
                            $deliveringDate = $offset->getDeliveringTime($addressShippingOffset, clone $from,/*$method->getTour(),*/ true);
                            // $date >= $deliveringDate
                            if ($date->compare($deliveringDate) >= 0) {
                                $var1= $date;
                                $var2= clone $var1;
                                $tagvorher= $var2->subDay(1);

                              /*  if(Mage::getResourceModel('ogsource/option')->getShippingTime($method->getTour()) =='0'||$noship->isPossible($tagvorher, $country, $region)){
                                    $this->_dateMethods[$date->get('yyyy-MM-dd')][] = $method->getCode();
                                }*/

                            }
                        }
                    }
                }

                $date->addDay(1);
            }
        }


        $dates = array_keys($this->_dateMethods);
        if (array_diff($this->_dateMethods[$dates[0]], $this->_dateMethods[$dates[1]]) == array_diff($this->_dateMethods[$dates[1]], $this->_dateMethods[$dates[0]])) {
            $this->_dateMethods = array_merge(array(self::NO_DATE => $this->_dateMethods[$dates[0]]), $this->_dateMethods);
        } else {
            $this->_dateMethods = array_merge(array(self::NO_DATE => $this->_dateMethods[$dates[1]]), $this->_dateMethods);
        }

        if ($asJson) {
            return Zend_Json::encode($this->_dateMethods);
        }

        return $this->_dateMethods;
    }

}
