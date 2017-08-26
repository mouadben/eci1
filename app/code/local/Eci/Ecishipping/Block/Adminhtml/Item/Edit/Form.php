<?php

class Eci_Ecishipping_Block_Adminhtml_Item_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $item = Mage::registry('ecishipping_item');

        $form = new Varien_Data_Form(array(
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'id' => 'edit_form',
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('item', array(
            'legend' => Mage::helper('ecishipping')->__('Item'),
        ));

        $fieldset->addField('surcharge_type', 'select', array(
            'name' => 'surcharge_type',
            'label' => Mage::helper('ecishipping')->__('Surcharge Type'),
            'values' => Eci_Ecishipping_Model_Item::getSurchargeTypeOptions(),
        ));

        $fieldset->addField('description', 'textarea', array(
            'name' => 'description',
            'label' => Mage::helper('ecishipping')->__('Description'),
        ));

        $fieldset = $form->addFieldset('item_mwsth', array(
            'legend' => Mage::helper('ecishipping')->__('Item MwSt. 19%'),
        ));

        $fieldset->addField('code_mwsth', 'text', array(
            'name' => 'code_mwsth',
            'label' => Mage::helper('ecishipping')->__('Code'),
            'required' => true,
        ));

        $fieldset->addField('cost_mwsth', 'text', array(
            'name' => 'cost_mwsth',
            'label' => Mage::helper('ecishipping')->__('Cost'),
            'required' => true,
        ));

        $fieldset->addField('title_mwsth', 'text', array(
            'name' => 'title_mwsth',
            'label' => Mage::helper('ecishipping')->__('Title'),
            'required' => true,
        ));

        $fieldset = $form->addFieldset('item_mwstl', array(
            'legend' => Mage::helper('ecishipping')->__('Item MwSt. 7%'),
        ));

        $fieldset->addField('code_mwstl', 'text', array(
            'name' => 'code_mwstl',
            'label' => Mage::helper('ecishipping')->__('Code'),
            'required' => true,
        ));

        $fieldset->addField('cost_mwstl', 'text', array(
            'name' => 'cost_mwstl',
            'label' => Mage::helper('ecishipping')->__('Cost'),
            'required' => true,
        ));

        $fieldset->addField('title_mwstl', 'text', array(
            'name' => 'title_mwstl',
            'label' => Mage::helper('ecishipping')->__('Title'),
            'required' => true,
        ));

        $form->setValues($item ? $item->getData() : null);
        $form->setUseContainer(true);
        $form->addFieldNameSuffix('item');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}