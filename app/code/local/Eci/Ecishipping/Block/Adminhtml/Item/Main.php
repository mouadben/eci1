<?php

class Eci_Ecishipping_Block_Adminhtml_Item_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $this->_blockGroup = 'ecishipping';
        $this->_controller = 'adminhtml_item_main';
        $this->_headerText = Mage::helper('ecishipping')->__('EC-Intelligent - Shipping Item');
		
        $this->_addButton('add', array(
            'label'   => Mage::helper('ecishipping')->__('Add Shipping Item'),
            'onclick' => "setLocation('{$this->getUrl('*/*/edit')}')",
            'class'   => 'add'
        ));
    }
}