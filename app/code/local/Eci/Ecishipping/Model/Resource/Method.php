<?php
class Eci_Ecishipping_Model_Resource_Method extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('ecishipping/method', 'method_id');
    }
    /**
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Eci_Ecishipping_Model_Resource_Method
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        parent::_beforeSave($object);
        $object->setData('delivery_day', implode(',', $object->getDataSetDefault('delivery_day', array())));
        $object->setData('country', implode(',', $object->getDataSetDefault('country', array())));
        $object->setData('customer_group', '*'.implode('*,*', $object->getDataSetDefault('customer_group', array())).'*');
        $object->setData('website', implode(',', $object->getDataSetDefault('website', array())));
        $object->setData('exclusive_category', implode(',', $object->getDataSetDefault('exclusive_category', array())));
        return $this;
    }
    /**
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Eci_Ecishipping_Model_Resource_Method
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        parent::_afterSave($object);
        /**
         * 1. Delete obsolete assigned websites
         * 2. Add or update assigned websites
         */
        if (is_array($object->getWebsite())) {
            $websiteTable = $this->getTable('ecishipping/method_website');
            $this->_getWriteAdapter()->delete($websiteTable, array(
                'method_id = ?' => $object->getId(),
                'website_id NOT IN (?)' => $object->getWebsite()
            ));
            foreach ($object->getWebsite() as $websiteId) {
                $data = array(
                    'method_id' => $object->getId(),
                    'website_id' => $websiteId
                );
                $this->_getWriteAdapter()->insertOnDuplicate($websiteTable, $data, array('method_id', 'website_id'));
            }
        }
        /**
         * 1. Delete obsolete assigned items
         * 2. Add or update assigned items
         */
        if (is_array($object->getItems())) {
            $itemTable = $this->getTable('ecishipping/method_item');
            $this->_getWriteAdapter()->delete($itemTable, array(
                'method_id = ?' => $object->getId(),
                'item_id NOT IN (?)' => $object->getWebsite()
            ));
            foreach ($object->getItems() as $itemId) {
                $data = array(
                    'method_id' => $object->getId(),
                    'item_id' => $itemId
                );
                $this->_getWriteAdapter()->insertOnDuplicate($itemTable, $data, array('method_id', 'item_id'));
            }
        }
        return $this;
    }
    /**
     * Exploder some fields to array
     * Add assigned websites and items
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Eci_Ecishipping_Model_Resource_Method
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        parent::_afterLoad($object);
        // explode data to array
        $object->setData('delivery_day', explode(',', $object->getData('delivery_day')));
        $object->setData('country', explode(',', $object->getData('country')));
        $string= substr($object->getData('customer_group'),1);
        $string = substr($string,0,-1);
        $object->setData('customer_group', explode('*,*',$string ));
        $object->setData('website', explode(',', $object->getData('website')));
        $ec = $object->getData('exclusive_category');
        if($ec) {
            $object->setData('exclusive_category', explode(',', $object->getData('exclusive_category')));
        }
        // load assignet website ids
        /*$select = $this->getReadConnection()->select()
            ->from($this->getTable('ecishipping/method_website'), array('website_id'))
            ->where('method_id = ?', $object->getId());
        $data = $this->getReadConnection()->fetchCol($select);
        $object->setData('website', $data);*/
        // load assigned item ids
        $select = $this->getReadConnection()->select()
            ->from($this->getTable('ecishipping/method_item'), array('item_id'))
            ->where('method_id = ?', $object->getId());
        $data = $this->getReadConnection()->fetchCol($select);
        $object->setData('items', $data);
        return $this;
    }
    /**
     * Override store depended labels
     *
     * @param Eci_Ecishipping_Model_Method $method
     * @param int $storeId
     * @return \Eci_Ecishipping_Model_Resource_Method
     */
    public function loadStoreLabels($method, $storeId)
    {
        if ($method->getId()) {
            $labelTable = $this->getTable('ecishipping/method_label');
            $select = $this->getReadConnection()->select()
                ->from($labelTable, array('field', 'value'))
                ->where('method_id = ?', $method->getId())
                ->where('store_id = ?', $storeId);
            $data = $this->getReadConnection()->fetchAssoc($select);
            foreach ($data as $row) {
                $method->setData($row['field'], $row['value']);
            }
        }
        return $this;
    }
    /**
     * Update, add or remove store depended labels
     *
     * @param Eci_Ecishipping_Model_Method $method
     * @param int $storeId
     * @param Varien_Object $postData
     * @param array $fields
     * @return Eci_Ecishipping_Model_Resource_Method
     */
    public function saveStoreLabels($method, $storeId, $postData, $fields)
    {
        $labelTable = $this->getTable('ecishipping/method_label');
        foreach ($fields as $field) {
            $value = trim($postData->getData($field));
            if ($value && $value != trim($method->getData($field))) {
                $data = array(
                    'method_id' => $method->getId(),
                    'store_id' => $storeId,
                    'field' => $field,
                    'value' => $value,
                );
                $this->_getWriteAdapter()->insertOnDuplicate($labelTable, $data, array('method_id', 'store_id', 'field'));
            } else {
                $this->_getWriteAdapter()->delete($labelTable, array(
                    'method_id = ?' => $method->getId(),
                    'store_id = ?' => $storeId,
                    'field = ?' => $field,
                ));
            }
        }
        return $this;
    }
}