<?php

class Eci_Ecishipping_Block_Adminhtml_Item_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/item')
                ->getCollection();
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {       
        $this->addColumn('code_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Code MwSt. 19%'),
            'index' => 'code_mwsth',
            'width' => '100px',
        ));

        $this->addColumn('cost_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Cost MwSt. 19%'),
            'index' => 'cost_mwsth',
            'type'  => 'currency',
            'width' => '100px',
        ));

        $this->addColumn('title_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Title MwSt. 19%'),
            'index' => 'title_mwsth',
            'width' => '250px',
        ));

        $this->addColumn('code_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Code MwSt. 7%'),
            'index' => 'code_mwstl',
            'width' => '100px',
        ));

        $this->addColumn('cost_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Cost MwSt. 7%'),
            'index' => 'cost_mwstl',
            'type'  => 'currency',
            'width' => '100px',
        ));

        $this->addColumn('title_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Title MwSt. 7%'),
            'index' => 'title_mwstl',
            'width' => '250px',
        ));
        
        $this->addColumn('surcharge_type', array(
            'header' => Mage::helper('ecishipping')->__('Surcharge Type'),
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Item::getSurchargeTypeOptions(),
            'index' => 'surcharge_type',
            'width' => '150px',
        ));
        
        $this->addColumn('description', array(
            'header' => Mage::helper('ecishipping')->__('Description'),
            'index' => 'description',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}

