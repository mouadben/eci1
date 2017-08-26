<?php

class Eci_Ecishipping_Model_Resource_Noship extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * 
     */
    protected function _construct()
    {
        $this->_init('ecishipping/noship', 'noship_id');
    }

}
