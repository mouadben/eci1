
<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table Ecishipping Method
 */

$installer->getConnection()->dropTable($installer->getTable('ecishipping/method'));

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/method'))
    ->addColumn('method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Method ID')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        'unsigned'  => true,
        ), 'Is Active')
    /*->addColumn('tour', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        'default'   => '',
        ), 'Tour')*/
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        'default'   => '',
        ), 'Title')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
        ), 'Description')
    ->addColumn('threshold_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        'unsigned'  => true,
        ), 'Threshold Type')
    ->addColumn('threshold_value', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '150.0',
        ), 'Threshold Value')
    ->addColumn('threshold_value_second', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '250.0000',
    ), 'Threshold Value second')

    ->addColumn('delivery_day', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => false,
        'default'   => '',
        ), 'Delivery Day')
    ->addColumn('country_specific', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        'unsigned'  => true,
        ), 'Country Specific')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
        ), 'Countries')
    ->addColumn('freeship', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => 0,
        ), 'Freeship')
    ->addColumn('exclusive_category', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => true,
        'default' => null,
    ), 'Exclusive Category')

    ->addColumn('is_payondelivery', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'  => 0,
    ), 'Is Pay On Delivery')
    ->addColumn('is_payonpick', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'  => 0,
    ), 'Is Pay On Pick')
    ->addColumn('customer_group_specific', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => 0,
        'unsigned' => true,
    ), 'Customer Group Specific')
    ->addColumn('customer_group', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
    ), 'Customer Group')
    ->addColumn('threshold_zeit', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => 0,
        'unsigned' => true,
    ), 'Threshold Zeit')
    ->addColumn('website', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
    ), 'Website')
    ->addColumn('sku_filter', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => 0,
    ), 'Sku Filter')
    ->addColumn('sku_liste', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
    ), 'Sku Liste')
    ->addColumn('auftragsrabat_filter', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => 0,
    ), 'Auftragsrabat Filter')
    ->addColumn('auftragsrabat_id', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
        'nullable'  => false,
        'default'   => '',
    ), 'Auftragsrabat Id')

    ->setComment('Ecishipping Method');
$installer->getConnection()->createTable($table);


/**
 * Create table Ecishipping Item
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/item'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/item'))
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Item ID')
    ->addColumn('code_mwsth', Varien_Db_Ddl_Table::TYPE_TEXT, 255 ,array(
        'nullable'  => false,
        'unsigned'  => true,
    ),'Code MwSt. 19'
    )

        ->addColumn('cost_mwsth', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4' ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Cost MwSt. 19'
        )
        ->addColumn('title_mwsth', Varien_Db_Ddl_Table::TYPE_TEXT, 255 ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Title MwSt. 19'
        )
        ->addColumn('code_mwstl', Varien_Db_Ddl_Table::TYPE_TEXT, 255 ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Code MwSt. 7'
        )
        ->addColumn('cost_mwstl', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4' ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Cost MwSt. 7'
        )
        ->addColumn('title_mwstl', Varien_Db_Ddl_Table::TYPE_TEXT, 255 ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Title MwSt. 7'
        )
        ->addColumn('tax_field_suffix', Varien_Db_Ddl_Table::TYPE_TEXT, 255 ,array(
            'nullable'  => false,
            'unsigned'  => true,
        ),'Tax Field Suffix'
        )


    ->addColumn('surcharge_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Item Code')


    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '4k', array(
        'nullable'  => false,
        'default'   => '',
        ), 'Description')
    ->addIndex($installer->getIdxName('ecishipping/item', array('code_mwsth','code_mwstl'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('code_mwsth','code_mwstl'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('Ecishipping Item');
$installer->getConnection()->createTable($table);


/**
 * Create table Ecishipping Offset
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/offset'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/offset'))
    ->addColumn('offset_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
    ), 'Delivering Time ID')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => false,
    ), 'Country')
    ->addColumn('region', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => false,
    ), 'Region')
    ->addColumn('postcode', Varien_Db_Ddl_Table::TYPE_TEXT, 16, array(
        'nullable'  => false,
    ), 'Postcode')
    ->addColumn('is_express', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Is Express')
    ->addColumn('delivery_time', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Delivery Time')
    ->addIndex($installer->getIdxName('ecishipping/offset', array('country', 'region', 'postcode', 'is_express'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('country', 'region', 'postcode', 'is_express'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('Ecishipping Offset');

$installer->getConnection()->createTable($table);


/**
 * Create table Ecishipping Noship
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/noship'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/noship'))
    ->addColumn('noship_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity ID')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => false,
        ), 'Country')
    ->addColumn('region', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => false,
        ), 'Region')
    ->addColumn('year', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        ), 'Year')
    ->addColumn('month', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        ), 'Month')
    ->addColumn('day', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        ), 'Day')
    ->addColumn('note', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Note')
    ->setComment('Ecishipping Noship');
$installer->getConnection()->createTable($table);


/**
 * Create table Ecishipping Method Item
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/method_item'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/method_item'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity ID')
    ->addColumn('method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Methode Id')
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Item ID')
    ->addIndex($installer->getIdxName('ecishipping/method_item', array('method_id')),
        array('method_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_item', array('item_id')),
        array('item_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_item', array('method_id', 'item_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('method_id', 'item_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('ecishipping/method_item', 'method_id', 'ecishipping/method', 'method_id'),
        'method_id', $installer->getTable('ecishipping/method'), 'method_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/method_item', 'item_id', 'ecishipping/method', 'item_id'),
        'item_id', $installer->getTable('ecishipping/item'), 'item_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Ecishipping Method Item');
$installer->getConnection()->createTable($table);

/**
 * Create table Ecishipping Methos Website
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/method_website'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/method_website'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity ID')
    ->addColumn('method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Methode Id')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Website ID')
    ->addIndex($installer->getIdxName('ecishipping/method_website', array('method_id')),
        array('method_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_website', array('website_id')),
        array('website_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_website', array('method_id', 'website_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('method_id', 'website_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('ecishipping/method_website', 'method_id', 'ecishipping/method', 'method_id'),
        'method_id', $installer->getTable('ecishipping/method'), 'method_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/method_website', 'website_id', 'core/website', 'website_id'),
        'website_id', $installer->getTable('core/website'), 'website_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Ecishipping Methos Website');
$installer->getConnection()->createTable($table);


/**
 * Create table Ecishipping Method Label
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/method_label'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/method_label'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity ID')
    ->addColumn('method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Methode Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Store ID')
    ->addColumn('field', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => false,
        'default'   => '',
        ), 'Field')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '4k', array(
        'nullable'  => false,
        'default'   => '',
        ), 'Value')
    ->addIndex($installer->getIdxName('ecishipping/method_label', array('method_id')),
        array('method_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_label', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('ecishipping/method_label', array('method_id', 'store_id', 'field'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('method_id', 'store_id', 'field'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('ecishipping/method_label', 'method_id', 'ecishipping/method', 'method_id'),
        'method_id', $installer->getTable('ecishipping/method'), 'method_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/method_label', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Ecishipping Method Label');
$installer->getConnection()->createTable($table);

/**
 * Create table Ecishipping Sales Order Method
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/sales_order_method'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/sales_order_method'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity Id')
    ->addColumn('quote_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Quote Id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Order Id')
    ->addColumn('method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Method Id')
    ->addColumn('delivery_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'unsigned'  => true,
        ), 'Delivery Date')
    ->addColumn('shipping_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'unsigned'  => true,
        ), 'Delivery Date')
    /*->addColumn('tour', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Tour')*/
    ->addColumn('shipping_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'unsigned'  => true,
        'default'   => 0,
        ), 'Shipping Amount')
    ->addColumn('manually_price', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => 0,
        ), 'Manually Price')
    ->addColumn('carrier_label', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Carrier Label')
    ->addColumn('method_label', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Method Label')
    ->addColumn('address_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
    ), 'Address Id')
    ->addColumn('manual', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default' => 0,
    ), 'Manual')


    ->addIndex($installer->getIdxName('ecishipping/sales_order_method', array('quote_id')), array('quote_id'))
    ->addIndex($installer->getIdxName('ecishipping/sales_order_method', array('order_id')), array('order_id'))
    ->addIndex($installer->getIdxName('ecishipping/sales_order_method', array('method_id')), array('method_id'))
    ->addForeignKey($installer->getFkName('ecishipping/sales_order_method', 'quote_id', 'sales/quote', 'entity_id'),
        'quote_id', $installer->getTable('sales/quote'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/sales_order_method', 'order_id', 'sales/order', 'entity_id'),
        'order_id', $installer->getTable('sales/order'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/sales_order_method', 'method_id', 'ecishipping/method', 'method_id'),
        'method_id', $installer->getTable('ecishipping/method'), 'method_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Ecishipping Sales Order Method');
$installer->getConnection()->createTable($table);

/**
 * Create table Ecishipping Sales Order Method Item
 */

/*$installer->getConnection()->dropTable($installer->getTable('ecishipping/sales_order_method_item'));*/

$table = $installer->getConnection()
    ->newTable($installer->getTable('ecishipping/sales_order_method_item'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true,
        ), 'Entity Id')
    ->addColumn('order_method_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        'unsigned'  => true,
        ), 'Method Id')
     ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        'unsigned'  => true,
        ), 'Item ID')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Code')
    ->addColumn('cost', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0',
        ), 'Cost')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        'default'   => '',
        ), 'Title')
    ->addIndex($installer->getIdxName('ecishipping/sales_order_method_item', array('order_method_id')), array('order_method_id'))
    ->addIndex($installer->getIdxName('ecishipping/sales_order_method_item', array('item_id')), array('item_id'))
    ->addIndex($installer->getIdxName('ecishipping/sales_order_method_item', array('order_method_id', 'item_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('order_method_id', 'item_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('ecishipping/sales_order_method_item', 'order_method_id', 'ecishipping/sales_order_method', 'entity_id'),
        'order_method_id', $installer->getTable('ecishipping/sales_order_method'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('ecishipping/sales_order_method_item', 'item_id', 'ecishipping/item', 'item_id'),
        'item_id', $installer->getTable('ecishipping/item'), 'item_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Ecishipping Sales Order Method Item');
$installer->getConnection()->createTable($table);


$installer->endSetup();
