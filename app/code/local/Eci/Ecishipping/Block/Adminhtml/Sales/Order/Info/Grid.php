<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Info_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping');
        $this->setDefaultLimit(100);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
        $this->setRowClickCallback('false');
    }

    public function _prepareCollection()
    {
        $this->setCollection($this->getGridCollection());

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('code', array(
            'header' => Mage::helper('ecishipping')->__('Code'),
            'index' => 'code',
            'width' => '102px',
            'sortable' => false,
        ));

        $this->addColumn('cost', array(
            'header' => Mage::helper('ecishipping')->__('Cost'),
            'index' => 'cost',
            'type' => 'currency',
            'width' => '102px',
            'sortable' => false,
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('ecishipping')->__('Title'),
            'index' => 'title',
            'sortable' => false,
        ));

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($item)
    {
        return null;
    }

}

