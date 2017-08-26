<?php

class Eci_Ecishipping_Adminhtml_EcishippingmethodController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }
    protected function _initMethod($strict = false)
    {
        if (Mage::registry('ecishipping_method')) {
            return Mage::registry('ecishipping_method');
        }

        $id = $this->getRequest()->getParam('id', null);

        $method = Mage::getModel('ecishipping/method');

        if ($strict || $id !== null) {
            $method->load($id);

            if (!$method->getId()) {
                throw new Exception($this->__('This method no longer exists.'));
            }

            $storeId = $this->getRequest()->getParam('store');
            if ($storeId) {
                $method->getResource()->loadStoreLabels($method, $storeId);
            }
        }

        Mage::register('ecishipping_method', $method);

        return $method;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('system/ecishipping/ecishippingmethod');
        $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('Methods'));
        $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_method_main'));
        $this->renderLayout();
    }

    public function editAction()
    {
        try {
            $this->_initMethod();

            if ($this->getRequest()->isAjax()) {
                $this->getResponse()->setBody($this->getLayout()->createBlock('ecishipping/adminhtml_method_edit_item')->toHtml());
            } else {

                $this->loadLayout();
                $this->_setActiveMenu('system/ecishipping/ecishippingmethod');
                $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('Methods'));
                $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_method_edit'));
                $this->renderLayout();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*');
        }
    }

    public function saveAction()
    {
        try {
            $method = $this->_initMethod();

            $postData = $this->getRequest()->getParam('method');
            $postData = new Varien_Object($postData);
            $postData->setItems($this->_getAssignedItemIds());

            if ($method->getId() && $postData->getStore()) {
                $method->getResource()->saveStoreLabels($method, $postData->getStore(), $postData, array('title', 'description'));
            } else {

                if ($method->getId()) {
                    $method->addData($postData->getData());
                } else {
                    $method->setData($postData->getData());
                    $method->setCreationTime(now());
                }

                $method->save();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The method has been saved.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if ($this->getRequest()->getParam('continue')) {
            $this->_redirect('*/*/edit', array('id' => $method->getId(), 'store' => $postData->getStore()));
        } else {
            $this->_redirect('*/*');
        }
    }

    public function deleteAction()
    {
        try {
            $method = $this->_initMethod(true);

            $method->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The method has been deleted.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*');
    }

    protected function _getAssignedItemIds()
    {
        $assignedItemIds = $this->_initMethod()->getItems();
        $assignedItemIds = array_flip($assignedItemIds);

        $items = $this->getRequest()->getParam('assigned_item_ids');

        if (isset($items['displayed'])) {
            foreach ($items['displayed'] as $itemId) {
                unset($assignedItemIds[$itemId]);
            }
        }

        if (isset($items['checked'])) {
            foreach ($items['checked'] as $itemId) {
                if ($itemId !== 'on') {
                    $assignedItemIds[$itemId] = true;
                }
            }
        }

        return array_keys($assignedItemIds);
    }

}