<?php

class Eci_Ecishipping_Block_Adminhtml_Noship_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $noship = Mage::registry('ecishipping_noship');

        $form = new Varien_Data_Form(array(
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'id' => 'edit_form',
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('method', array(
            'legend' => Mage::helper('ecishipping')->__('No Ship Date'),
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
        
        $fieldset->addField('year', 'text', array(
            'name' => 'year',
            'label' => Mage::helper('ecishipping')->__('Year'),
            'required' => true,
        ));
        
        $fieldset->addField('month', 'select', array(
            'name' => 'month',
            'label' => Mage::helper('ecishipping')->__('Month'),
            'required' => true,
            'values' => $this->getOptions(12),
        ));

        $fieldset->addField('day', 'select', array(
            'name' => 'day',
            'label' => Mage::helper('ecishipping')->__('Day'),
            'required' => true,
            'values' => $this->getOptions(31),
        ));
        
        $fieldset->addField('note', 'textarea', array(
            'name' => 'note',
            'label' => Mage::helper('ecishipping')->__('Note'),
        ));

        if($noship->getId()) {
            $form->setValues($noship->getData());
        } else {
            $form->setValues($noship->getDafault());
        }
        
        $form->setUseContainer(true);
        $form->addFieldNameSuffix('noship');
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    public function getOptions($values)
    {
        $options = array('*');
        
        for($i = 1 ; $i <= $values ; $i++) {
            $id = ($i<10) ? "0{$i}" : $i;
            $options[$id] = $id;
        }
        
        return $options;
    }

}