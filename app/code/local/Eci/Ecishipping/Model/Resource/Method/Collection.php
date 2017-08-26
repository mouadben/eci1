<?php
class Eci_Ecishipping_Model_Resource_Method_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected $_noLoad = false;
    protected function _construct()
    {
        $this->_init('ecishipping/method');
    }
    protected function _afterLoadData()
    {
        parent::_afterLoadData();
        if (!$this->_noLoad) {
            foreach ($this->getItems() as $method) {
                $method->load($method->getId());
            }
        }
    }
    public function setNoLoad($value)
    {
        $this->_noLoad = $value;
    }
    public function addCountryFilter($country)
    {
        $this->getSelect()->where('(country LIKE ? OR country = \'\')', "%{$country}%");
    }
    public function addCustomerGroupFilter($customer_group)
    {
        $this->getSelect()->where('(customer_group_specific = "1" AND customer_group LIKE "%*'.$customer_group.'*%" ) OR (customer_group_specific = "0")');
    }
    /*public function addPlzFilter($plz){
        $all_tours= implode(Mage::getResourceModel('ogsource/option')->getAllowedTours($plz),',');
        $this->getSelect()->where('find_in_set(tour,"'.$all_tours.'")');
    }*/
    public function addValueFilter($grand_total){
        $this->getSelect()->where('(threshold_type = 6 AND threshold_value_second >='.$grand_total.')OR'
            .'(threshold_type = 1 AND threshold_value >'.$grand_total.')OR'
            .'(threshold_type = 2 AND threshold_value >='.$grand_total.')OR'
            .'(threshold_type = 3 AND threshold_value ='.$grand_total.')OR'
            .'(threshold_type = 4 )OR'
            .'(threshold_type = 5 )OR'
            .'(threshold_type = 0)')
        ;
    }
    public function addWebsiteFilter($customer_web_id){
        $this->getSelect()->where('(website LIKE ? OR website = \'\')', "%{$customer_web_id}%");
    }

    public function addSkusFilter($methodenIds){
        if(count($methodenIds)){
            $text=implode($methodenIds,',');
            $this->getSelect()->where('(sku_filter = "1" AND find_in_set(method_id,"'.$text.'") ) OR (sku_filter = "0")');
        }else{
            $this->getSelect()->where('(sku_filter = "0")');
        }
    }
}