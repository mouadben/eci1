<?php

class Eci_Ecishipping_Adminhtml_EcishippingnecishippingController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }
    protected function _initNecishipping($strict = false)
    {
        $id = $this->getRequest()->getParam('id', null);

        $necishipping = Mage::getModel('ecishipping/necishipping');

        if ($strict || $id !== null) {
            $necishipping->load($id);

            if (!$necishipping->getId()) {
                throw new Exception($this->__('This no ship no longer exists.'));
            }
        }

        Mage::register('ecishipping_necishipping', $necishipping);

        return $necishipping;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('system/ecishipping/necishipping');
        $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('No Ship'));
        $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_necishipping_main'));
        $this->renderLayout();
    }

    public function editAction()
    {
        try {
            $this->_initNecishipping();

            $this->loadLayout();
            $this->_setActiveMenu('system/ecishipping/necishipping');
            $this->_title($this->__('System'))->_title($this->__('EC-Intelligent - Shipping'))->_title($this->__('No Ship'));
            $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_necishipping_edit'));
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
            $necishipping = $this->_initNecishipping();

            $postData = $this->getRequest()->getParam('necishipping');
            $postData = new Varien_Object($postData);
    
            if ($necishipping->getId()) {
                $necishipping->addData($postData->getData());
            } else {
                $necishipping->setData($postData->getData());
                $necishipping->setCreationTime(now());
            }

            $necishipping->save();
                
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The no ship has been saved.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if($this->getRequest()->getParam('continue')) {
            $this->_redirect('*/*/edit', array('id' => $necishipping->getId()));
        } else {
            $this->_redirect('*/*');
        }
    }

    public function deleteAction()
    {
        try {
            $necishipping = $this->_initNecishipping(true);

            $necishipping->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The no ship has been deleted.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*');
    }

}