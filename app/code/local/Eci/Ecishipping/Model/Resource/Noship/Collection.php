<?php

class Eci_Ecishipping_Model_Resource_Noship_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('ecishipping/noship');
    }
    
    public function addAddressFilter($country, $region)
    {
        $adapter = $this->getConnection();
               
        $any = '*';
        
        $this->getSelect()
            ->where(implode(' OR ', array(
                $adapter->quoteInto('main_table.country LIKE ?', $country),
                $adapter->quoteInto('main_table.country LIKE ?', $any),
            )))->where(implode(' OR ', array(
                $adapter->quoteInto('main_table.region LIKE ?', $region),
                $adapter->quoteInto('main_table.region LIKE ?', $any),
            )))->order(array('main_table.country DESC', 'main_table.region DESC'));

        return $this;
    }

}
