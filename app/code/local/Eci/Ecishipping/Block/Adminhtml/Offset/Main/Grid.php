<?php

class Eci_Ecishipping_Block_Adminhtml_Offset_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/offset')
                ->getCollection();
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {       
        $this->addColumn('country', array(
            'header' => Mage::helper('ecishipping')->__('Country'),
            'index' => 'country',
            'width' => '80px',
        ));
        
        $this->addColumn('region', array(
            'header' => Mage::helper('ecishipping')->__('Region'),
            'index' => 'region',
            'width' => '80px',
        ));
        
        $this->addColumn('postcode', array(
            'header' => Mage::helper('ecishipping')->__('Postcode'),
            'index' => 'postcode',
            'width' => '80px',
        ));
        
        $this->addColumn('is_express', array(
            'header' => Mage::helper('ecishipping')->__('Is Express'),
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Offset::getIsExpress(),
            'index' => 'is_express',
            'width' => '80px',
        ));

        $this->addColumn('delivery_time', array(
            'header' => Mage::helper('ecishipping')->__('Delivery Time'),
            'index' => 'delivery_time',
            'width' => '100px',
        ));


        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    public function _day($offset)
    {
        $daysLocale = Mage::app()->getLocale()->getTranslationList('days');
        $daysLocale = $daysLocale['format']['abbreviated'];
        
        $days = array(
            '0' => $daysLocale['sun'],
            '1' => $daysLocale['mon'],
            '2' => $daysLocale['tue'],
            '3' => $daysLocale['wed'],
            '4' => $daysLocale['thu'],
            '5' => $daysLocale['fri'],
            '6' => $daysLocale['sat'],
        );
        
        $aDays = array();
        
        foreach(explode(',', $offset->getDay()) as $day)
        {
            $aDays[] = $days[$day];
        }
        
        return implode(', ', $aDays);
    }

}

