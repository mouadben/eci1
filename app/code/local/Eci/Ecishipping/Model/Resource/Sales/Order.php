<?php

class Eci_Ecishipping_Model_Resource_Sales_Order extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('ecishipping/sales_order_method', 'entity_id');
    }

    public function addItem(Mage_Core_Model_Abstract $object, Eci_Ecishipping_Model_Item $item)
    {
        if ($object->getId()) {

            $data = array(
                'order_method_id' => $object->getId(),
                'item_id' => $item->getId(),
            );

            $this->_getWriteAdapter()->insertOnDuplicate($this->getTable('ecishipping/sales_order_method_item'), $data, array_keys($data));
        }

        return $this;
    }

    public function removeItem(Mage_Core_Model_Abstract $object, $itemId)
    {
        if ($object->getId() && $itemId) {
            $adapter = $this->_getWriteAdapter();

            $adapter->delete($this->getTable('ecishipping/sales_order_method_item'), array(
                $adapter->quoteInto('order_method_id = ?', $object->getId()),
                $adapter->quoteInto('item_id = ?', $itemId)
            ));

            if ($object->getItems() instanceof Varien_Data_Collection) {
                $object->getItems()->removeItemByKey($itemId);
            }
        }

        return $this;
    }

    public function removeItems(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $adapter = $this->_getWriteAdapter();

            $adapter->delete($this->getTable('ecishipping/sales_order_method_item'), array(
                $adapter->quoteInto('order_method_id = ?', $object->getId()),
            ));

            if ($object->getItems() instanceof Varien_Data_Collection) {
                $object->getItems()->clear();
            }
        }

        return $this;
    }

    public function collectCost(Mage_Core_Model_Abstract $object)
    {
        $cost = 0;

        if ($object->getId()) {
            $select = $this->getReadConnection()->select()
                ->from($this->getTable('ecishipping/sales_order_method_item'), 'SUM(cost)')
                ->where('order_method_id = ?', $object->getId());

            $cost = $this->getReadConnection()->fetchOne($select);
        }

        return $cost;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId() && $object->getItems() instanceof Varien_Data_Collection) {
            $items = clone $object->getItems();
            $this->removeItems($object);
            foreach ($items as $item) {

                    $shippingItem = new Eci_Ecishipping_Model_Item();
                    $shippingItem->load($item->getId());
Mage::log('mouad'.$object->getData('tax_field_suffix'));
                    if($shippingItem->getId()) {
                        $data = array(
                            'order_method_id' => $object->getId(),
                            'item_id' => $item->getId(),
                            'code' =>  $shippingItem->getData('code'.$object->getData('tax_field_suffix')),
                            'cost' =>  $shippingItem->getData('cost'.$object->getData('tax_field_suffix')),
                            'title' =>  $shippingItem->getData('title'.$object->getData('tax_field_suffix')),
                        );

   #                     $this->_getWriteAdapter()->insertOnDuplicate($this->getTable('ecishipping/sales_order_method_item'), $data, array_keys($data));
                    }

            }
        }

        return parent::_afterSave($object);
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $collection = new Varien_Data_Collection();

        if ($object->getId()) {
            $select = $this->getReadConnection()->select()
                ->from($this->getTable('ecishipping/sales_order_method_item'))
                ->where('order_method_id = ?', $object->getId());

            $items = $this->getReadConnection()->fetchAssoc($select);

            if (count($items)) {

                foreach ($items as $item) {
                    $item = new Varien_Object($item);
                    $item->setIdFieldName('item_id');
                    $collection->addItem($item);
                }
            }
        }

        $object->setData('items', $collection);

        return parent::_afterLoad($object);
    }

}
