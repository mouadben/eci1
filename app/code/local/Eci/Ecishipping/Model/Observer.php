<?php

class Eci_Ecishipping_Model_Observer
{

    public function observerQuoteSaveAfter(Varien_Event_Observer $event)
    {
        $quote = $event->getData('quote');

        Mage::getModel('ecishipping/sales_order')->updateFromQuote($quote);
    }

    public function observerOrderSaveAfter(Varien_Event_Observer $event)
    {
        $order = $event->getData('order');

        Mage::getModel('ecishipping/sales_order')->updateFromOrder($order);
    }

    public function observerAdminhtmlSalesOrderCreateProcessDataBefore(Varien_Event_Observer $event)
    {
        $orderCreateModel = $event->getData('order_create_model');
        $requestModel = $event->getData('request_model');
        $session = $event->getData('session');

        Mage::getModel('ecishipping/sales_order')->updateFromCreate($orderCreateModel, $requestModel, $session);
    }
    
    public function observerSaveShippingMethod(Varien_Event_Observer $observer)
    {
        /* @var $request Mage_Core_Controller_Request_Http */
        $request = $observer->getRequest();
        $session = Mage::getSingleton('checkout/session');
        if ($request->getPost('delivery_accept')) {
            $session->setData('ecishipping_delivery_accept', true);
        } else {
            $session->setData('ecishipping_delivery_accept', false);
        }
    }
    
    public function observerSalesOrderPlaceAfter(Varien_Event_Observer $observer) 
    {
        /* @var $order Mage_Sales_Model_Order */
        $order = $observer->getOrder();
        $session = Mage::getSingleton('checkout/session');
        $helper = Mage::helper('ecishipping');
        if ($session->getData('ecishipping_delivery_accept')) {
            $comment = $helper->__('KUNDE WILL KEINEN ANRUF! HAKEN WURDE IM FRONTEND GESETZT!');
            $order->addStatusHistoryComment($comment);
        }
    }
}
