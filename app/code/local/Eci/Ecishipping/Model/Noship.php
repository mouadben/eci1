
<?php

class Eci_Ecishipping_Model_Noship extends Mage_Core_Model_Abstract
{

    protected $_collection = null;

    protected function _construct()
    {
        $this->_init('ecishipping/noship');
    }

    /**
     *
     * @return array 
     */
    public function getDafault()
    {
        return array(
            'country' => 'DE',
            'region' => '*',
            'year' => '*',
            'month' => '01',
            'day' => '01',
        );
    }

    /**
     *
     * @param Zend_Date $date
     * @param string $country
     * @param string $region
     * @return boolean 
     */
    public function isPossible(Zend_Date $date, $country = null, $region = null)
    {
        if($country === null && $region === null) {
            return true;
        }
        
        if ($this->_collection === null) {
            $this->_collection = $this->getCollection();
        }

        $year = $date->get('yyyy');
        $month = $date->get('MM');
        $day = $date->get('dd');

        foreach ($this->_collection as $noShip) {

            $_country = trim($noShip->getData('country'));
            $_region = trim($noShip->getData('region'));
            $_year = trim($noShip->getData('year'));
            $_month = trim($noShip->getData('month'));
            $_day = trim($noShip->getData('day'));

            if (($_country === '*' || $_country === $country) &&
                    ($_year === '*' || $_year === $year) &&
                    ($_month === '*' || $_month === $month) &&
                    ($_day === '*' || $_day === $day) &&
                    ($_region === '*' || $_region === $region)
            ) {
                 return false;
              }
            }


        return true;
    }

}
