<?php

class Eci_Ecishipping_Block_Adminhtml_Noship_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'ecishipping';
        $this->_controller = 'adminhtml_noship';
        $this->_mode = 'edit';

        parent::__construct();
    }

    protected function _prepareLayout()
    {
        $this->_addButton('save_and_continue', array(
            'label'     => Mage::helper('ecishipping')->__('Save and Continue Edit'),
            'onclick'   => 'editForm.submit(\''. $this->_getSaveAndContinueUrl() .'\');',
            'class'     => 'save',
        ), 10);

        return parent::_prepareLayout();
    }
    
    public function getHeaderText()
    {
        if (Mage::registry('ecishipping_noship') && Mage::registry('ecishipping_noship')->getId()) {
            return Mage::helper('ecishipping')->__('Edit No Ship Date');
        } else {
            return Mage::helper('ecishipping')->__('New No Ship Date');
        }
    }
    
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array('continue' => true, 'id' => $this->getRequest()->getParam('id')));
    }

}
