<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Info extends Mage_Adminhtml_Block_Abstract
{

    public function _toHtml()
    {
        if ($this->getOrder()) {
            $salesOrder = Mage::getModel('ecishipping/sales_order')->loadByOrderId($this->getOrder()->getId());

            if ($salesOrder->getId()) {

                $salesOrder->setTitle($this->getOrder()->getShippingDescription());
                $salesOrder->setShippingAmount($this->getOrder()->formatBasePrice($salesOrder->getShippingAmount()));

                $grid = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_Order_info_grid');
                $form = $this->getLayout()->createBlock('ecishipping/adminhtml_sales_Order_info_form');

                $grid->setGridCollection($salesOrder->getItems());
                $form->setFormValues($salesOrder);

                return $grid->toHtml() . $form->toHtml();
            }
        }

        return null;
    }

}
