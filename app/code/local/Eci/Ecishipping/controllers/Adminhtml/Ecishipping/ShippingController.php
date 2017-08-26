<?php

class Eci_Ecishipping_Adminhtml_Ecishipping_ShippingController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }

    public function itemgridAction()
    {
       
        $salesOrderId = $this->getRequest()->getParam('so');
        $salesOrder = Mage::getModel('ecishipping/sales_order');
        
        if($salesOrderId) {
            $salesOrder->load($salesOrderId);
        }
        
        echo Mage::app()->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_grid_item')->setSalesOrder($salesOrder)->toHtml();
    }
    
    public function methodgridAction()
    {
       
        $salesOrderId = $this->getRequest()->getParam('so');
        $salesOrder = Mage::getModel('ecishipping/sales_order');
        
        if($salesOrderId) {
            $salesOrder->load($salesOrderId);
        }
        
        echo Mage::app()->getLayout()->createBlock('ecishipping/adminhtml_sales_order_form_grid_method')->setSalesOrder($salesOrder)->toHtml();
    }

}