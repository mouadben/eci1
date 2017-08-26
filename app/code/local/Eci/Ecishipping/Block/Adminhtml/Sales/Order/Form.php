<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Form extends Mage_Adminhtml_Block_Abstract
{


    public function _toHtml()
    {

        $salesOrder = Mage::getModel('ecishipping/sales_order');

        if ($this->getQuote()) {
            $salesOrder->loadByQouteId($this->getQuote()->getId());
        }

        if (!$salesOrder->getCarrierLabel()) {
            $storeId = $this->getQuote()->getStoreId();
            $salesOrder->setCarrierLabel(Mage::getStoreConfig('carriers/ecishipping/title', $storeId));
        }

        if (!$salesOrder->getMethodLabel()) {
            $salesOrder->setMethodLabel(Mage::helper('ecishipping')->__('Individually'));
        }

        if ($salesOrder->getManual()) {
            $itemGrid = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_grid_item')->setSalesOrder($salesOrder)->setQuote($this->getQuote());
            $manualForm = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_manual')->setSalesOrder($salesOrder)->setQuote($this->getQuote());
            $baseForm = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_base')->setSalesOrder($salesOrder)->setQuote($this->getQuote());

            return $itemGrid->toHtml() . $manualForm->toHtml() . $baseForm->toHtml();
        } else {
            $methodGrid = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_grid_method')->setSalesOrder($salesOrder)->setQuote($this->getQuote());
            $baseForm = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_base')->setSalesOrder($salesOrder)->setQuote($this->getQuote());

            return $methodGrid->toHtml() . $baseForm->toHtml() . '<div class="shipping-reload" style="display: none;"></div><div class="shipping-reload-button" style="display: none;">'.$this->_buttonReload().'</div>';
        }
    }


    protected function _buttonReload()
    {
        return $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
            'type' => 'button',
            'title' => Mage::helper('ecishipping')->__('Update'),
            'label' => Mage::helper('ecishipping')->__('Update'),
            'onclick' => 'ecishipping.updateAfterShippingAddressChange();',
            'style' => 'width: 251px;'
        ))->toHtml();
    }
}
