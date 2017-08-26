<?php

class Eci_Ecishipping_Model_Offset extends Mage_Core_Model_Abstract
{

    const IS_EXPRESS_NO = 0;
    const IS_EXPRESS_YES = 1;


    /**
     * 0 = Sunday, ..., 6 = Saturday
     */
    protected $_noTransportDays = array(0);


    protected function _construct()
    {

        $this->_init('ecishipping/offset');
    }


    public function getDafault()
    {

        return array(
            'country' => 'DE',
            'region' => '*',
            'postcode' => '*',
            'delivery_time' => '1',
            'is_express' => '0',
        );
    }


    static public function getIsExpress()
    {

        return array(
            self::IS_EXPRESS_YES => Mage::helper('ecishipping')->__('Yes'),
            self::IS_EXPRESS_NO => Mage::helper('ecishipping')->__('No'),
        );
    }

    public function getDeliveringTime($addressShippingOffset, Zend_Date $from, /*$tour,*/ $returnDate = false)
    {


        // to avoid endless loop
        $maxOffset = Mage::getStoreConfig(Eci_Ecishipping_Block_Carrier_Form::XML_PATH_CARRIERS_OSHIP_DAYSPREORDER);

        /*$offset= Mage::getResourceModel('ogsource/option')->getShippingTime($tour);

        if ($offset === 'null' && $addressShippingOffset) {
            $offset = $addressShippingOffset; }
        if ($offset === 'null') {
            $offset = Mage::getStoreConfig('carriers/ecishipping/daysoffset');
        }
        $thresholdZeit = Mage::getResourceModel('ogsource/option')->getThresholdZeit($tour);
        if($thresholdZeit)
        {
            $thresholdHour = intval($thresholdZeit);
        }
        else
        {
            $thresholdHour = intval(Mage::getStoreConfig('carriers/ecishipping/threshold_hour'));
        }

        if ($thresholdHour >= 1 && $thresholdHour <= 23) {
            $tz = new DateTimeZone(Mage::getStoreConfig('general/locale/timezone'));
            $now = new DateTime('now', $tz);
            $ref = new DateTime('now', $tz);
            $ref->setTime($thresholdHour, 0, 0);

            if ($now > $ref) {
                $offset++;
            }
        }
*/
        /**
         * if Sunday is betwien from date and from date + offset do offset ++
         */
  /*      for ($i = 0; $i < $offset; $i++) {

            $from->addDay(1);

            if ($offset < $maxOffset && in_array($from->get(Zend_Date::WEEKDAY_DIGIT), $this->_noTransportDays)) {
                $offset++;
            }
        }
*/
        if ($returnDate === true) {
            return $from;
        }

        return $offset;
    }


    public function getDeliveringTimeBack($addressShippingOffset, Zend_Date $from)
    {

        $maxOffset = Mage::getStoreConfig(Eci_Ecishipping_Block_Carrier_Form::XML_PATH_CARRIERS_OSHIP_DAYSPREORDER);
        $offset = $addressShippingOffset;

        /**
         * if Sunday is betwien from date and from date + offset do offset ++
         */
        for ($i = 0; $i < $offset; $i++) {

            $from->subDay(1);

            if ($offset < $maxOffset && in_array($from->get(Zend_Date::WEEKDAY_DIGIT), $this->_noTransportDays)) {
                $offset++;
            }
        }

        return $offset;
    }
}
