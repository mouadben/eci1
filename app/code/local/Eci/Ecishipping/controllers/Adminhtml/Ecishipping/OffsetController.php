<?php

class Eci_Ecishipping_Adminhtml_Ecishipping_OffsetController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }
    protected function _initOffset($strict = false)
    {
        $id = $this->getRequest()->getParam('id', null);

        $offset = Mage::getModel('ecishipping/offset');

        if ($strict || $id !== null) {
            $offset->load($id);

            if (!$offset->getId()) {
                throw new Exception($this->__('This delivering offset no longer exists.'));
            }
        }

        Mage::register('ecishipping_offset', $offset);

        return $offset;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('eciintel/ecishipping/offset');
        $this->_title($this->__('EC-Intelligent'))->_title($this->__('Shipping'))->_title($this->__('Delivering Offset'));
        $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_offset_main'));
        $this->renderLayout();
    }

    public function editAction()
    {
        try {
            $this->_initOffset();

            $this->loadLayout();
            $this->_setActiveMenu('eciintel/ecishipping/offset');
            $this->_title($this->__('EC-Intelligent'))->_title($this->__('Shipping'))->_title($this->__('Delivering Offset'));
            $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_offset_edit'));
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
            $offset = $this->_initOffset();

            $postData = $this->getRequest()->getParam('offset');
            $postData = new Varien_Object($postData);
    
            if ($offset->getId()) {
                $offset->addData($postData->getData());
            } else {
                $offset->setData($postData->getData());
                $offset->setCreationTime(now());
            }

            $offset->save();
                
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The delivering offset has been saved.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if($this->getRequest()->getParam('continue')) {
            $this->_redirect('*/*/edit', array('id' => $offset->getId()));
        } else {
            $this->_redirect('*/*');
        }
    }

    public function deleteAction()
    {
        try {
            $offset = $this->_initOffset(true);

            $offset->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The delivering offset has been deleted.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*');
    }

}