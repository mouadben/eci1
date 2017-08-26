<?php

class Eci_Ecishipping_Block_Adminhtml_Noship_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/noship')
                ->getCollection();
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {       
        $this->addColumn('country', array(
            'header' => Mage::helper('ecishipping')->__('Country'),
            'index' => 'country',
            'width' => '100px',
        ));
        
        $this->addColumn('region', array(
            'header' => Mage::helper('ecishipping')->__('Region'),
            'index' => 'region',
            'width' => '100px',
        ));
        
        $this->addColumn('year', array(
            'header' => Mage::helper('ecishipping')->__('Year'),
            'index' => 'year',
            'width' => '100px',
        ));
        
        $this->addColumn('month', array(
            'header' => Mage::helper('ecishipping')->__('Month'),
            'index' => 'month',
            'width' => '100px',
        ));
        
        $this->addColumn('day', array(
            'header' => Mage::helper('ecishipping')->__('Day'),
            'index' => 'day',
            'width' => '100px',
        ));
        
        $this->addColumn('note', array(
            'header' => Mage::helper('ecishipping')->__('Note'),
            'index' => 'note',
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}

