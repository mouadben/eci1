<?php

class Eci_Ecishipping_Block_Adminhtml_Method_Main extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $this->_blockGroup = 'ecishipping';
        $this->_controller = 'adminhtml_method_main';
        $this->_headerText = Mage::helper('ecishipping')->__('EC-Intelligent - Shipping Methods');
		
        $this->_addButton('add', array(
            'label'   => Mage::helper('ecishipping')->__('Add Shipping Methods'),
            'onclick' => "setLocation('{$this->getUrl('*/*/edit')}')",
            'class'   => 'add'
        ));
    }
}