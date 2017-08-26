<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vfranz
 * Date: 21.11.12
 * Time: 12:47
 * To change this template use File | Settings | File Templates.
 */
class Eci_Ecishipping_Block_Email_Shippingdate extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        if($this->getOrder() && $this->getOrder()->getId()) {
            /** @var $ecishippingSalesOrder Eci_Ecishipping_Model_Sales_Order */
            $ecishippingSalesOrder = Mage::getModel('ecishipping/sales_order');
            $ecishippingSalesOrder->loadByOrderId($this->getOrder()->getId());

            if($ecishippingSalesOrder->getDeliveryDate()) {
                $date = Mage::helper('core')->formatDate($ecishippingSalesOrder->getDeliveryDate(), 'full', false);
                return sprintf('%s %s',$this->__('Delivery Date:'), $date);
            }
        }

        return '';
    }
}
