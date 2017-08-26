<?php

class Eci_Ecishipping_Model_Method extends Mage_Core_Model_Abstract
{

    const ACTIVE_YES = 1;
    const ACTIVE_NO = 2;
    const COUNTRY_ALL = 0;
    const COUNTRY_SPEC = 1;
    const THRESHOLD_OFF = 0;
    const THRESHOLD_LT = 1;
    const THRESHOLD_LTEQ = 2;
    const THRESHOLD_EQ = 3;
    const THRESHOLD_GTEQ = 4;
    const THRESHOLD_GT = 5;
    const THRESHOLD_GT_AND_LESS = 6;
    const FREESHIP_NO = 0;
    const FREESHIP_YES = 1;
    const ALLE_KUNDEN_GRUPPEN = 0;
    const BESTIMMTE_KUNDEN_GRUPPEN = 1;

    protected $_items = null;

    protected function _construct()
    {
        $this->_init('ecishipping/method');
    }

    public function loadByShippingMethodCode($shippingMethodCode)
    {
        $shippingMethodCode = explode('_', $shippingMethodCode);
        
        if(count($shippingMethodCode) === 2 && $shippingMethodCode[0] == Eci_Ecishipping_Model_Carrier_Ecishipping::CODE) {
            $this->load($shippingMethodCode[1]);
        }
        
        return $this;
        
    }
    
    protected function _afterLoad()
    {
        $this->_items = null;
        parent::_afterLoad();
    }

    /**
     *
     * @return array 
     */
    static public function getActiveOptions()
    {
        return array(
            self::ACTIVE_YES => Mage::helper('ecishipping')->__('Yes'),
            self::ACTIVE_NO => Mage::helper('ecishipping')->__('No'),
        );
    }

    /**
     *
     * @return array 
     */
    static public function getThresholdOptions()
    {
        return array(
            self::THRESHOLD_OFF => Mage::helper('ecishipping')->__('Disabled'),
            self::THRESHOLD_LT => Mage::helper('ecishipping')->__('Less ( < )'),
            self::THRESHOLD_LTEQ => Mage::helper('ecishipping')->__('Less Or Equal ( < / = )'),
            self::THRESHOLD_EQ => Mage::helper('ecishipping')->__('Equal ( = )'),
            self::THRESHOLD_GTEQ => Mage::helper('ecishipping')->__('Greater Or Equal ( > / = )'),
            self::THRESHOLD_GT => Mage::helper('ecishipping')->__('Greater ( > )'),
            self::THRESHOLD_GT_AND_LESS => Mage::helper('ecishipping')->__('Gr and Less ( > < )'),
        );
    }

    static public function getKundenGruppenOptions()
    {
        return array(
            self::ALLE_KUNDEN_GRUPPEN => Mage::helper('ecishipping')->__('Alle Kunden Gruppen'),
            self::BESTIMMTE_KUNDEN_GRUPPEN => Mage::helper('ecishipping')->__('Bestimmte Kunden Gruppen'),
        );
    }

    static public function getFreeshipOptions()
    {
        return array(
            self::FREESHIP_NO => Mage::helper('ecishipping')->__('No'),
            self::FREESHIP_YES => Mage::helper('ecishipping')->__('Yes'),
        );
    }

    static public function getOptionWeekdays()
    {
        return Mage::app()->getLocale()->getOptionWeekdays();
    }

    /**
     *
     * @param type $storeId
     * @return \Eci_Ecishipping_Model_Method
     */
    public function loadStoreLabels($storeId)
    {
        $this->getResource()->loadStoreLabels($this, $storeId);

        return $this;
    }

    /**
     *
     * @return Eci_Ecishipping_Model_Resource_Item_Collection
     */
    public function getItemCollection()
    {
        if ($this->_items === null) {
            $itemIds = is_array($this->getItems()) ? $this->getItems() : array(0);
            $this->_items = Mage::getModel('ecishipping/item')->getCollection();
            $this->_items->addFieldToFilter('item_id', array('in' => $itemIds));
        }

        return $this->_items;
    }

    /**
     *
     * @return float
     */
    public function getCost($taxFieldSuffix = Eci_Ecishipping_Helper_Data::TAX_FIELD_SUFFIX_19)
    {
        $cost = array(0);

        if ($this->getItemCollection() && $this->getItemCollection()->count()) {
            $cost = $this->getItemCollection()->getColumnValues('cost'.$taxFieldSuffix);
        }

        return array_sum($cost);
    }

    /**
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getId() ? $this->getId() : 0;
    }

    public function getThreshold_zeit()
    {
        return $this->getThresholdZeit() ? $this->getThresholdZeit() : Mage::getStoreConfig('carriers/ecishipping/threshold_hour');
    }

    /**
     *
     * @return boolean 
     */
    public function isExpress()
    {
        if ($this->getItemCollection() && $this->getItemCollection()->count()) {
            foreach ($this->getItemCollection() as $item) {
                if ($item->getSurchargeType() == Eci_Ecishipping_Model_Item::SURCHARGE_TYPE_EXPRESS) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check methode avalible for date
     * 
     * @param Zend_Date $date
     * @param type $isExpress
     * @return boolean
     */
    public function isAvailableForDay(Zend_Date $date)
    {
        if ($this->getId()) {
            if (in_array($date->get(Zend_Date::WEEKDAY_DIGIT), $this->getDeliveryDay())) {
                return true;
            }
        }

        return false ;
    }
    
    public function getCarrierLabel($storeId = null)
    {
        if($storeId === null) {
            return Mage::getStoreConfig('carriers/ecishipping/title');
        }
        
        return Mage::getStoreConfig('carriers/ecishipping/title', $storeId);
    }
/*
    static public function getProductGroupOptions()
    {
        # @var $attribute Mage_Catalog_Model_Entity_Attribute
        $attribute = Mage::getModel('catalog/entity_attribute');
        $attribute->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'csb_warengruppe');

        return $attribute->getSource()->getAllOptions();
    }
*/
}
