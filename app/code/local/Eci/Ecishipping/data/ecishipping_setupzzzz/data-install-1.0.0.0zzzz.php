<?php

ecishipping_setup_data_items();
ecishipping_setup_data_method();
ecishipping_setup_data_noship();
ecishipping_setup_data_offset();

function ecishipping_setup_data_items()
{
    $items = array(
        array('code' => 9000, 'surcharge_type' => 1, 'cost' => 35.2200, 'title' => 'VK', 'description' => ''),
        array('code' => 9001, 'surcharge_type' => 1, 'cost' => 36.4500, 'title' => 'VK', 'description' => ''),
        array('code' => 9002, 'surcharge_type' => 1, 'cost' => 6.9000, 'title' => 'VK', 'description' => ''),
        array('code' => 9003, 'surcharge_type' => 1, 'cost' => 27.1000, 'title' => 'VK', 'description' => ''),
        array('code' => 9004, 'surcharge_type' => 1, 'cost' => 67.2900, 'title' => 'VK', 'description' => ''),
        array('code' => 9005, 'surcharge_type' => 1, 'cost' => 36.4400, 'title' => 'VK', 'description' => ''),
        array('code' => 9006, 'surcharge_type' => 1, 'cost' => 23.8300, 'title' => 'VK', 'description' => ''),
        array('code' => 9007, 'surcharge_type' => 1, 'cost' => 55.1400, 'title' => 'VK', 'description' => ''),
        array('code' => 9008, 'surcharge_type' => 1, 'cost' => 50.4600, 'title' => 'VK', 'description' => ''),
        array('code' => 9009, 'surcharge_type' => 1, 'cost' => 46.2600, 'title' => 'VK', 'description' => ''),
        array('code' => 9010, 'surcharge_type' => 1, 'cost' => 15.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9011, 'surcharge_type' => 1, 'cost' => 9.2530, 'title' => 'Standardversand', 'description' => ''),
        array('code' => 9012, 'surcharge_type' => 1, 'cost' => 0.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9013, 'surcharge_type' => 1, 'cost' => 4.1170, 'title' => 'VK', 'description' => ''),
        array('code' => 9014, 'surcharge_type' => 1, 'cost' => 6.6300, 'title' => 'VK', 'description' => ''),
        array('code' => 9015, 'surcharge_type' => 1, 'cost' => 16.5000, 'title' => 'VK', 'description' => ''),
        array('code' => 9016, 'surcharge_type' => 1, 'cost' => 13.4000, 'title' => 'VK', 'description' => ''),
        array('code' => 9017, 'surcharge_type' => 1, 'cost' => 1.3550, 'title' => 'VK', 'description' => ''),
        array('code' => 9018, 'surcharge_type' => 2, 'cost' => 7.0090, 'title' => 'Expresszuschlag', 'description' => ''),
        array('code' => 9019, 'surcharge_type' => 3, 'cost' => 29.9070, 'title' => 'Samstagszuschlag', 'description' => ''),
        array('code' => 9020, 'surcharge_type' => 1, 'cost' => 0.0000, 'title' => 'Versandkostenfrei', 'description' => ''),
        array('code' => 9021, 'surcharge_type' => 1, 'cost' => 8.7000, 'title' => 'VK', 'description' => ''),
        array('code' => 9022, 'surcharge_type' => 1, 'cost' => 8.8000, 'title' => 'VK', 'description' => ''),
        array('code' => 9023, 'surcharge_type' => 1, 'cost' => 70.0900, 'title' => 'VK', 'description' => ''),
        array('code' => 9024, 'surcharge_type' => 1, 'cost' => 44.3900, 'title' => 'VK', 'description' => ''),
        array('code' => 9025, 'surcharge_type' => 1, 'cost' => 32.7100, 'title' => 'VK', 'description' => ''),
        array('code' => 9026, 'surcharge_type' => 1, 'cost' => 27.1000, 'title' => 'VK', 'description' => ''),
        array('code' => 9027, 'surcharge_type' => 1, 'cost' => 15.4200, 'title' => 'VK', 'description' => ''),
        array('code' => 9028, 'surcharge_type' => 1, 'cost' => 30.3700, 'title' => 'VK', 'description' => ''),
        array('code' => 9029, 'surcharge_type' => 1, 'cost' => 120.5600, 'title' => 'VK', 'description' => ''),
        array('code' => 9030, 'surcharge_type' => 1, 'cost' => 44.3900, 'title' => 'VK', 'description' => ''),
        array('code' => 9031, 'surcharge_type' => 1, 'cost' => 45.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9032, 'surcharge_type' => 1, 'cost' => 11.6800, 'title' => 'VK', 'description' => ''),
        array('code' => 9033, 'surcharge_type' => 1, 'cost' => 55.1400, 'title' => 'VK', 'description' => ''),
        array('code' => 9034, 'surcharge_type' => 1, 'cost' => 0.7500, 'title' => 'VK', 'description' => ''),
        array('code' => 9035, 'surcharge_type' => 1, 'cost' => 50.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9036, 'surcharge_type' => 1, 'cost' => 54.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9037, 'surcharge_type' => 1, 'cost' => 25.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9038, 'surcharge_type' => 1, 'cost' => 20.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9039, 'surcharge_type' => 1, 'cost' => 202.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9040, 'surcharge_type' => 1, 'cost' => 50.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9041, 'surcharge_type' => 1, 'cost' => 8.3190, 'title' => 'VK', 'description' => ''),
        array('code' => 9042, 'surcharge_type' => 1, 'cost' => 4.5790, 'title' => 'VK', 'description' => ''),
        array('code' => 9043, 'surcharge_type' => 1, 'cost' => 8.3190, 'title' => 'VK', 'description' => ''),
        array('code' => 9044, 'surcharge_type' => 1, 'cost' => 30.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9045, 'surcharge_type' => 1, 'cost' => 15.0000, 'title' => 'VK', 'description' => ''),
        array('code' => 9046, 'surcharge_type' => 1, 'cost' => 7.3800, 'title' => 'VK', 'description' => ''),
        array('code' => 9096, 'surcharge_type' => 1, 'cost' => 5.5140, 'title' => 'VK', 'description' => ''),
    );

    foreach ($items as $item) {
        Mage::getModel('ecishipping/item')->setData($item)->save();
    }
}

function ecishipping_setup_data_method()
{
    $websites = array_keys($websites = Mage::app()->getWebsites());
    
    $methods = array(
        array(
            'is_active' => 1,
            'tour' => 'S111',
            'title' => 'Standardversand',
            'description' => '',
            'threshold_type' => 1,
            'threshold_value' => 150,
            'delivery_day' => array(2, 3, 4, 5),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(12),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S112',
            'title' => 'Versandkostenfrei',
            'description' => '',
            'threshold_type' => 4,
            'threshold_value' => 150,
            'delivery_day' => array(2, 3, 4, 5),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(21),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S113',
            'title' => 'Standardversand + Expresszuschlag',
            'description' => '',
            'threshold_type' => 1,
            'threshold_value' => 150,
            'delivery_day' => array(2,3,4,5),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(12, 19),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S114',
            'title' => 'Versandkostenfrei + Expresszuschlag',
            'description' => '',
            'threshold_type' => 4,
            'threshold_value' => 150,
            'delivery_day' => array(2,3,4,5),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(19, 21),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S115',
            'title' => 'Standardversand + Samstagszuschlag',
            'description' => 'Wird nur bis 12 Uhr geliefert.',
            'threshold_type' => 1,
            'threshold_value' => 150,
            'delivery_day' => array(6),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(12, 20),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S116',
            'title' => 'Versandkostenfrei + Samstagszuschlag',
            'description' => '',
            'threshold_type' => 4,
            'threshold_value' => 150,
            'delivery_day' => array(6),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(20, 21),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S117',
            'title' => 'Standardversand + Samstagszuschlag + Expresszuschlag',
            'description' => '',
            'threshold_type' => 1,
            'threshold_value' => 150,
            'delivery_day' => array(6),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(12, 19, 20),
        ),
        array(
            'is_active' => 1,
            'tour' => 'S118',
            'title' => 'Versandkostenfrei + Samstagszuschlag + Expresszuschlag',
            'description' => '',
            'threshold_type' => 4,
            'threshold_value' => 150,
            'delivery_day' => array(6),
            'country_specific' => 1,
            'country' => array('DE'),
            'website' => $websites,
            'items' => array(19, 20, 21),
        ),
    );

    foreach ($methods as $method) {
        Mage::getModel('ecishipping/method')->setData($method)->save();
    }
}

function ecishipping_setup_data_noship()
{
    $noships = array(
        array('country' => 'DE', 'region' => '*', 'year' => '*', 'month' => '01', 'day' => '02', 'note' => 'Neujahrstag'),
       
        array('country' => 'DE', 'region' => 'BAW', 'year' => '*', 'month' => '01', 'day' => '06', 'note' => 'Heilige Drei Könige'),
        array('country' => 'DE', 'region' => 'BAY', 'year' => '*', 'month' => '01', 'day' => '06', 'note' => 'Heilige Drei Könige'),
        array('country' => 'DE', 'region' => 'SAC', 'year' => '*', 'month' => '01', 'day' => '06', 'note' => 'Heilige Drei Könige'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '2012', 'month' => '04', 'day' => '06', 'note' => 'Karfreitag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2013', 'month' => '03', 'day' => '29', 'note' => 'Karfreitag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2014', 'month' => '04', 'day' => '18', 'note' => 'Karfreitag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2015', 'month' => '04', 'day' => '03', 'note' => 'Karfreitag'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '2012', 'month' => '04', 'day' => '09', 'note' => 'Ostermontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2013', 'month' => '04', 'day' => '01', 'note' => 'Ostermontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2014', 'month' => '04', 'day' => '21', 'note' => 'Ostermontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2015', 'month' => '04', 'day' => '06', 'note' => 'Ostermontag'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '*', 'month' => '05', 'day' => '01', 'note' => 'Tag der Arbeit'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '2012', 'month' => '05', 'day' => '17', 'note' => 'Christi Himmelfahrt'),
        array('country' => 'DE', 'region' => '*', 'year' => '2013', 'month' => '05', 'day' => '09', 'note' => 'Christi Himmelfahrt'),
        array('country' => 'DE', 'region' => '*', 'year' => '2014', 'month' => '05', 'day' => '29', 'note' => 'Christi Himmelfahrt'),
        array('country' => 'DE', 'region' => '*', 'year' => '2015', 'month' => '05', 'day' => '14', 'note' => 'Christi Himmelfahrt'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '2012', 'month' => '05', 'day' => '28', 'note' => 'Pfingstmontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2013', 'month' => '05', 'day' => '20', 'note' => 'Pfingstmontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2014', 'month' => '06', 'day' => '06', 'note' => 'Pfingstmontag'),
        array('country' => 'DE', 'region' => '*', 'year' => '2015', 'month' => '05', 'day' => '25', 'note' => 'Pfingstmontag'),
        
        array('country' => 'DE', 'region' => 'BAW', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAW', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAW', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAW', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'BAY', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAY', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAY', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'BAY', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'HES', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'HES', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'HES', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'HES', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'NRW', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'NRW', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'NRW', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'NRW', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'RHE', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'RHE', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'RHE', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'RHE', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'SAR', 'year' => '2012', 'month' => '06', 'day' => '07', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'SAR', 'year' => '2013', 'month' => '05', 'day' => '30', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'SAR', 'year' => '2014', 'month' => '06', 'day' => '19', 'note' => 'Fronleichnam'),
        array('country' => 'DE', 'region' => 'SAR', 'year' => '2015', 'month' => '06', 'day' => '04', 'note' => 'Fronleichnam'),
        
        array('country' => 'DE', 'region' => 'SAR', 'year' => '*', 'month' => '08', 'day' => '15', 'note' => 'Mariä Himmelfahrt'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '*', 'month' => '10', 'day' => '03', 'note' => 'Tag der Deutschen Einheit'),
        
        array('country' => 'DE', 'region' => 'BRG', 'year' => '*', 'month' => '10', 'day' => '31', 'note' => 'Reformationstag'),
        array('country' => 'DE', 'region' => 'MEC', 'year' => '*', 'month' => '10', 'day' => '31', 'note' => 'Reformationstag'),
        array('country' => 'DE', 'region' => 'SAS', 'year' => '*', 'month' => '10', 'day' => '31', 'note' => 'Reformationstag'),
        array('country' => 'DE', 'region' => 'SAC', 'year' => '*', 'month' => '10', 'day' => '31', 'note' => 'Reformationstag'),
        array('country' => 'DE', 'region' => 'THE', 'year' => '*', 'month' => '10', 'day' => '31', 'note' => 'Reformationstag'),
        
        array('country' => 'DE', 'region' => 'BER', 'year' => '*', 'month' => '11', 'day' => '01', 'note' => 'Allerheiligen'),
        array('country' => 'DE', 'region' => 'BAY', 'year' => '*', 'month' => '11', 'day' => '01', 'note' => 'Allerheiligen'),
        array('country' => 'DE', 'region' => 'NRW', 'year' => '*', 'month' => '11', 'day' => '01', 'note' => 'Allerheiligen'),
        array('country' => 'DE', 'region' => 'RHE', 'year' => '*', 'month' => '11', 'day' => '01', 'note' => 'Allerheiligen'),
        array('country' => 'DE', 'region' => 'SAR', 'year' => '*', 'month' => '11', 'day' => '01', 'note' => 'Allerheiligen'),
        
        array('country' => 'DE', 'region' => 'SAS', 'year' => '2012', 'month' => '11', 'day' => '18', 'note' => 'Buß- und Bettag'),
        array('country' => 'DE', 'region' => 'SAS', 'year' => '2013', 'month' => '11', 'day' => '17', 'note' => 'Buß- und Bettag'),
        array('country' => 'DE', 'region' => 'SAS', 'year' => '2014', 'month' => '11', 'day' => '16', 'note' => 'Buß- und Bettag'),
        array('country' => 'DE', 'region' => 'SAS', 'year' => '2015', 'month' => '11', 'day' => '15', 'note' => 'Buß- und Bettag'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '*', 'month' => '12', 'day' => '25', 'note' => '1. Weihnachtstag'),
        
        array('country' => 'DE', 'region' => '*', 'year' => '*', 'month' => '12', 'day' => '26', 'note' => '2. Weihnachtstag'),
    );
    
    foreach ($noships as $noship) {
        Mage::getModel('ecishipping/noship')->setData($noship)->save();
    }
}

function ecishipping_setup_data_offset()
{
    $offsets = array(
        array('country' => 'DE', 'region' => '*', 'postcode' => '*', 'is_express' => 0, 'delivery_time' => '1'),
        array('country' => 'DE', 'region' => '*', 'postcode' => '*', 'is_express' => 1, 'delivery_time' => '1'),
        array('country' => 'AT', 'region' => '*', 'postcode' => '*', 'is_express' => 0, 'delivery_time' => '2'),
        array('country' => 'AT', 'region' => '*', 'postcode' => '*', 'is_express' => 1, 'delivery_time' => '1'),
        array('country' => 'CH', 'region' => '*', 'postcode' => '*', 'is_express' => 0, 'delivery_time' => '2'),
        array('country' => 'CH', 'region' => '*', 'postcode' => '*', 'is_express' => 1, 'delivery_time' => '1'),
        array('country' => 'PL', 'region' => '*', 'postcode' => '*', 'is_express' => 0, 'delivery_time' => '3'),
        array('country' => 'PL', 'region' => '*', 'postcode' => '*', 'is_express' => 1, 'delivery_time' => '2'),
        array('country' => '*', 'region' => '*', 'postcode' => '*', 'is_express' => 0, 'delivery_time' => '4'),
    );
    
    foreach ($offsets as $offset) {
        Mage::getModel('ecishipping/offset')->setData($offset)->save();
    }
}