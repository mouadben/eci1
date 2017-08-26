<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Form_Grid_Method extends Mage_Adminhtml_Block_Widget_Grid
{

    public function getTemplate()
    {

        return 'ecishipping/order/create/grid.phtml';
    }


    public function __construct()
    {

        parent::__construct();
        $this->setId('ecishipping_methodgrid');
        $this->setDefaultLimit(200);
        $this->setUseAjax(true);
        $this->setRowClickCallback('ecishipping.shippingGridRowClick.bind(ecishipping)');
        $this->setCheckboxCheckCallback('ecishipping.shippingMethodGridCheckboxCheck.bind(ecishipping)');
    }


    protected function _prepareCollection()
    {

        /** @var $collection Eci_Ecishipping_Model_Resource_Method_Collection */
        $collection = Mage::getModel('ecishipping/method')->getCollection();
        $allItems = $this->getQuote()->getAllItems();
        $skusArr = $this->getSkusArray($allItems);
        $country = $this->getQuote()->getShippingAddress()->getCountryId();
        $customer_group = $this->getQuote()->getCustomerGroupId();
        $customer_web_id = Mage::getModel('customer/customer')->load($this->getQuote()->getCustomerId())->getData('website_id');
        $postcode = $this->getQuote()->getShippingAddress()->getPostcode();
        $grand_total=$this->getQuote()->getData('grand_total');
        //$collection->addFieldToFilter('is_active', Eci_Ecishipping_Model_Method::ACTIVE_YES);//active methods
        $methoden = Mage::getModel('ecishipping/method')->getCollection();
        $methodenIds=array();
        if(count($skusArr)&& count($methoden)){
            foreach($methoden as $method){
                if($method->getSkuFilter()){
                    foreach($skusArr as $sku){
                        if(strpos($method->getSkuListe(),"*".$sku."*")!==false){
                            $methodenIds[]=   $method->getMethodId();
                        }
                    }
                }
            }
            $collection->addSkusFilter($methodenIds);
        }
        if ($country)
        {
            $collection->addCountryFilter($country);
        }
        if ($customer_group)
        {
            $collection->addCustomerGroupFilter($customer_group);
        }
       /* if($postcode){
            $collection->addPlzFilter($postcode);
        }*/
        if($grand_total){
            $collection->addValueFilter($grand_total);
        }
        if($customer_web_id){
            $collection->addWebsiteFilter($customer_web_id);
        }
        $collection->setOrder('title','ASC');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function getSkusArray($allItems){
        $skusArray =array();
        foreach($allItems as $item){
            $skusArray[]= $item->getData('sku');
        }
        return $skusArray;
    }
    protected function _addColumnFilterToCollection($column)
    {

        if ($column->getId() == 'assigned_method_id') {

            $assignedMethodId = $this->getAssignedMethodId();

            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('method_id', array('in' => $assignedMethodId));
            } else {
                $this->getCollection()->addFieldToFilter('method_id', array('nin' => $assignedMethodId));
            }
        }

        return parent::_addColumnFilterToCollection($column);
    }


    protected function _prepareColumns()
    {

        $this->addColumn('assigned_method_id', array(
            'type' => 'radio',
            'value' => $this->getAssignedMethodId(),
            'align' => 'center',
            'index' => 'method_id',
            'header' => ' ',
            'width' => '60px',
        ));

        $this->addColumn('titel', array(
            'header' => Mage::helper('ecishipping')->__('Title'),
            'index' => 'title',
        ));

        return parent::_prepareColumns();
    }


    public function getGridUrl()
    {

        if ($this->getSalesOrder()) {
            return $this->getUrl('*/ecishipping_shipping/methodgrid/', array('so' => $this->getSalesOrder()->getId()));
        }

        return $this->getUrl('*/ecishipping_shipping/methodgrid/');
    }


    public function getAssignedMethodId()
    {

        return $this->getSalesOrder()->getData('method_id');
    }


    /**
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {

        if ($this->getData('quote')) {
            return $this->getData('quote');
        } else {
            return Mage::getSingleton('adminhtml/session_quote')->getQuote();
        }
    }
}

