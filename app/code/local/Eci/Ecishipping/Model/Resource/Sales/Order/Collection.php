<?php

class Eci_Ecishipping_Model_Resource_Sales_Order_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('ecishipping/sales_order');
    }

}
