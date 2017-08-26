<?php

class Eci_Ecishipping_Adminhtml_EcishippingitemController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }
    protected function _initItem($strict = false)
    {
        $id = $this->getRequest()->getParam('id', null);

        $item = Mage::getModel('ecishipping/item');

        if ($strict || $id !== null) {
            $item->load($id);

            if (!$item->getId()) {
                throw new Exception($this->__('This item no longer exists.'));
            }
        }

        Mage::register('ecishipping_item', $item);

        return $item;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('system/ecishipping/ecishippingitem');
        $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('Item'));
        $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_item_main'));
        $this->renderLayout();
    }

    public function editAction()
    {
        try {
            $this->_initItem();

            $this->loadLayout();
            $this->_setActiveMenu('system/ecishipping/ecishippingitem');
            $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('Item'));
            $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_item_edit'));
            $this->renderLayout();
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*');
        }
    }

    public function saveAction()
    {
        try {
            $item = $this->_initItem();

            $postData = $this->getRequest()->getParam('item');
            $postData = new Varien_Object($postData);
    
            if ($item->getId()) {
                $item->addData($postData->getData());
            } else {
                $item->setData($postData->getData());
                $item->setCreationTime(now());
            }

            $item->save();
                
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The item has been saved.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if($this->getRequest()->getParam('continue')) {
            $this->_redirect('*/*/edit', array('id' => $item->getId()));
        } else {
            $this->_redirect('*/*');
        }
    }

    public function deleteAction()
    {
        try {
            $item = $this->_initItem(true);

            $item->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The item has been deleted.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*');
    }

}