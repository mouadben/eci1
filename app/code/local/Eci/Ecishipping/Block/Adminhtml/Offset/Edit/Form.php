<?php

class Eci_Ecishipping_Block_Adminhtml_Offset_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $offset = Mage::registry('ecishipping_offset');

        $form = new Varien_Data_Form(array(
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'id' => 'edit_form',
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('method', array(
            'legend' => Mage::helper('ecishipping')->__('Delivering Offset'),
        ));

        $fieldset->addField('country', 'select', array(
            'name' => 'country',
            'label' => Mage::helper('ecishipping')->__('Country'),
            'required' => true,
            'values' => Mage::getResourceModel('directory/country_collection')->loadData()->toOptionArray(false),
        ));
        
        $fieldset->addField('region', 'text', array(
            'name' => 'region',
            'label' => Mage::helper('ecishipping')->__('Region'),
            'required' => true,
        ));
        
        $fieldset->addField('postcode', 'text', array(
            'name' => 'postcode',
            'label' => Mage::helper('ecishipping')->__('Postcode'),
            'required' => true,
        ));
        
        $fieldset->addField('is_express', 'select', array(
            'name' => 'is_express',
            'label' => Mage::helper('ecishipping')->__('Is Express'),
            'values' => Eci_Ecishipping_Model_Offset::getIsExpress(),
        ));

        $fieldset->addField('delivery_time', 'text', array(
            'name' => 'delivery_time',
            'label' => Mage::helper('ecishipping')->__('Delivery Time'),
            'required' => true,
        ));
        
        
        if($offset->getId()) {
            $form->setValues($offset->getData());
        } else {
            $form->setValues($offset->getDafault());
        }
        
        $form->setUseContainer(true);
        $form->addFieldNameSuffix('offset');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}