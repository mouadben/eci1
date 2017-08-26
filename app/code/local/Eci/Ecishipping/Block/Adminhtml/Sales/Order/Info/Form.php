<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Info_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('shipping', array(
            'no_container' => true,
        ));

        $fieldset->addField('carrier_label', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Carrier'),
            'text' => $this->_boldText($this->getFormValues()->getCarrierLabel()),
        ));
        
        $fieldset->addField('method_label', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Method'),
            'text' => $this->_boldText($this->getFormValues()->getMethodLabel()),
        ));
        
       /* $fieldset->addField('tour', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Tour'),
            'text' => $this->_boldText($this->getFormValues()->getTour()),
        ));
        */
        $fieldset->addField('shipping_date', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Shipping Date'),
            'text' => $this->_boldText(Mage::helper('core')->formatDate($this->getFormValues()->getShippingDate(), 'medium')),
        ));
        
        $fieldset->addField('delivery_date', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Delivery Date'),
            'text' => $this->_boldText(Mage::helper('core')->formatDate($this->getFormValues()->getDeliveryDate(), 'medium')),
        ));

        $fieldset->addField('shipping_amount', 'note', array(
            'label' => Mage::helper('ecishipping')->__('Shipping Amount'),
            'text' => $this->_boldText($this->getFormValues()->getShippingAmount()),
        ));


        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function _boldText($value)
    {
        return '<strong>' . $value . '</strong>';
    }

}
