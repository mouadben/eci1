<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Form_Base extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('shipping_apply_fieldset', array(
            'no_container' => true,
            'table_class' => 'form-list fieldset-wide',
        ));

        $note = '';
        if($this->getSalesOrder() && $this->getSalesOrder()->hasDateError($this->getSalesOrder()->getData('delivery_date'))) {
            $note = '<span style="color: red;">'.Mage::helper('ecishipping')->__('Delivery Date smaller than now!').'</span>';
        } elseif($this->getSalesOrder() && $this->getSalesOrder()->hasDateError($this->getSalesOrder()->getData('delivery_date'), $this->getSalesOrder()->getData('shipping_date'))) {
            $note = '<span style="color: red;">'.Mage::helper('ecishipping')->__('Delivery Date smaller than Shipping Date!').'</span>';
        }

        $fieldset->addField('delivery_date', 'date', array(
            'name' => 'delivery_date',
            'label' => Mage::helper('ecishipping')->__('Delivery Date'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
            'note' => $note,
        ));


        $note = '';
        if($this->getSalesOrder() && $this->getSalesOrder()->hasDateError($this->getSalesOrder()->getData('shipping_date'))) {
            $note = '<span style="color: red;">'.Mage::helper('ecishipping')->__('Shipping Date smaller than now!').'</span>';
        } elseif($this->getSalesOrder() && $this->getSalesOrder()->hasDateError($this->getSalesOrder()->getData('delivery_date'), $this->getSalesOrder()->getData('shipping_date'))) {
            $note = '<span style="color: red;">'.Mage::helper('ecishipping')->__('Shipping Date greater than Delivery Date!').'</span>';
        }

        $fieldset->addField('shipping_date', 'date', array(
            'name' => 'shipping_date',
            'label' => Mage::helper('ecishipping')->__('Shipping Date'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
            'note' => $note,
        ));

        /*$fieldset->addField('tour', 'select', array(
            'name' => 'tour',
            'label' => Mage::helper('ecishipping')->__('Tour'),
            'values' => Mage::getModel('ogsource/tour')->toOptionArray(),
            'required' => true,
        ));*/

        $buttonApply = $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
            'type' => 'button',
            'title' => Mage::helper('ecishipping')->__('Apply'),
            'label' => Mage::helper('ecishipping')->__('Apply'),
            'onclick' => 'ecishipping.shippingApply()',
            'class' => 'save',
            'style' => 'width: 251px;'
        ))->toHtml();

        if($this->getSalesOrder()->getManual()) {
            $buttonForm = $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
                'type' => 'button',
                'title' => Mage::helper('ecishipping')->__('Switch to Default Settings'),
                'label' => Mage::helper('ecishipping')->__('Switch to Default Settings'),
                'onclick' => 'ecishipping.shippingViewDefault()',
                'style' => 'width: 251px;'
            ))->toHtml();
        } else {
            $buttonForm = $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
                'type' => 'button',
                'title' => Mage::helper('ecishipping')->__('Switch to Manual Settings'),
                'label' => Mage::helper('ecishipping')->__('Switch to Manual Settings'),
                'onclick' => 'ecishipping.shippingViewManual()',
                'style' => 'width: 251px;'
            ))->toHtml();
        }


        $fieldset->addField('button_apply_date', 'note', array(
            'text' => '<p style="text-align: right;">' . $buttonForm . '&nbsp;&nbsp;&nbsp;&nbsp;' . $buttonApply . '</p>',
        ));

        if ($this->getSalesOrder()) {
            $form->setValues($this->getSalesOrder()->getData());
        }

        $form->setHtmlIdPrefix('shipping_method_');
        $form->addFieldNameSuffix('shipping_method');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
