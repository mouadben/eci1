<?php

class Eci_Ecishipping_Model_Resource_Offset extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('ecishipping/offset', 'offset_id');
    }

}
