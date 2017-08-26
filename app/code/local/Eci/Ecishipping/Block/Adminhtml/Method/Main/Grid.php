<?php

class Eci_Ecishipping_Block_Adminhtml_Method_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/method')
                ->getCollection();
        
        $collection->setNoLoad(true);
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('method_id', array(
            'header' => Mage::helper('ecishipping')->__('Methode ID'),
            'index' => 'method_id',
            'width' => '60px',
        ));
        
        $this->addColumn('title', array(
            'header' => Mage::helper('ecishipping')->__('Title'),
            'index' => 'title',
        ));
        
        $this->addColumn('is_active', array(
            'header' => Mage::helper('ecishipping')->__('Is Active'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Method::getActiveOptions(),
            'width' => '60px',
            'align' => 'center',
        ));
       /*
        $this->addColumn('tour', array(
            'header' => Mage::helper('ecishipping')->__('Tour'),
            'index' => 'tour',
            'width' => '150px',
            'type' => 'options',
            'options' => Mage::getModel('ogsource/tour')->getAllOptions(false),
        ));
*/
        $this->addColumn('threshold_type', array(
            'header' => Mage::helper('ecishipping')->__('threshold_type'),
            'index' => 'threshold_type',
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Method::getThresholdOptions(),
            'width' => '150px',
        ));
        
        $this->addColumn('threshold_value', array(
            'header' => Mage::helper('ecishipping')->__('threshold_value'),
            'index' => 'threshold_value',
            'type'  => 'currency',
            'width' => '100px',
        ));
        
        $this->addColumn('freeship', array(
            'header' => Mage::helper('ecishipping')->__('Free Shipping'),
            'index' => 'freeship',
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Method::getFreeshipOptions(),
            'width' => '150px',
        ));
        
        $this->addColumn('country', array(
            'header' => Mage::helper('ecishipping')->__('Country'),
            'index' => 'country',
        ));
        
        /*$this->addColumn('websites', array(
            'header' => Mage::helper('ecishipping')->__('Websites'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'index' => 'websites',
            'type' => 'options',
            'options' => Mage::getModel('core/website')->getCollection()->toOptionHash(),
        ));*/

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}

