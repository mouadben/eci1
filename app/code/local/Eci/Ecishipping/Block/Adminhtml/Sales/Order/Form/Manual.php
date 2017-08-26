<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Form_Manual extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('shipping', array(
            'no_container' => true,
            'table_class' => 'form-list fieldset-wide',
                ));

        $fieldset->addField('carrier_label', 'text', array(
            'name' => 'carrier_label',
            'label' => Mage::helper('ecishipping')->__('Carrier'),
            'required' => true,
        ));

        $fieldset->addField('method_label', 'text', array(
            'name' => 'method_label',
            'label' => Mage::helper('ecishipping')->__('Method'),
            'required' => true,
        ));

        $allowManuallyPrice = Mage::helper('ecishipping')->allowManuallyPrice();
        if ($allowManuallyPrice) {
            $fieldset->addField('manually_price_checkbox', 'checkbox', array(
                'name' => 'manually_price_checkbox',
                'label' => Mage::helper('ecishipping')->__('Manually Price'),
                'onclick' => 'ecishipping.manuallyPrice(this)',
                'checked' => true,
            ));
        }

        $fieldset->addField('shipping_amount', 'text', array(
            'name' => 'shipping_amount',
            'label' => Mage::helper('ecishipping')->__('Shipping Amount'),
        ));

//        $showImageHtml = $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
//            'type' => 'button',
//            'title' => Mage::helper('ecishipping')->__('Apply Settings'),
//            'label' => Mage::helper('ecishipping')->__('Apply Settings'),
//            'onclick' => 'ecishipping.shippingManualApply()',
//            'class' => 'save',
//            'style' => 'width: 150px;'
//        ))->toHtml();
//
//        $fieldset->addField('button', 'note', array(
//            'text' => '<p style="text-align: right;">' . $showImageHtml . '</p>',
//        ));

        if ($this->getSalesOrder()) {
            $form->setValues($this->getSalesOrder()->getData());
        }
        
        if (!($allowManuallyPrice && $this->getSalesOrder() && $this->getSalesOrder()->getManuallyPrice())) {
            $form->getElement('shipping_amount')->setDisabled('disabled');
            
            if($form->getElement('manually_price_checkbox')) {
                $form->getElement('manually_price_checkbox')->setChecked(false);
            }
        }

        $form->setHtmlIdPrefix('shipping_method_');
        $form->addFieldNameSuffix('shipping_method');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
