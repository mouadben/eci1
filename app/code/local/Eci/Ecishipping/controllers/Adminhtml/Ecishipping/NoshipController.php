<?php

class Eci_Ecishipping_Adminhtml_Ecishipping_NoshipController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }
    protected function _initNoship($strict = false)
    {
        $id = $this->getRequest()->getParam('id', null);

        $noship = Mage::getModel('ecishipping/noship');

        if ($strict || $id !== null) {
            $noship->load($id);

            if (!$noship->getId()) {
                throw new Exception($this->__('This no ship no longer exists.'));
            }
        }

        Mage::register('ecishipping_noship', $noship);

        return $noship;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('eciintel/ecishipping/noship');
        $this->_title($this->__('EC-Intelligent'))->_title($this->__('Shipping'))->_title($this->__('No Ship'));
        $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_noship_main'));
        $this->renderLayout();
    }

    public function editAction()
    {
        try {
            $this->_initNoship();

            $this->loadLayout();
            $this->_setActiveMenu('eciintel/ecishipping/noship');
            $this->_title($this->__('EC-Intelligent'))->_title($this->__('Shipping'))->_title($this->__('No Ship'));
            $this->_addContent($this->getLayout()->createBlock('ecishipping/adminhtml_noship_edit'));
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
            $noship = $this->_initNoship();

            $postData = $this->getRequest()->getParam('noship');
            $postData = new Varien_Object($postData);
    
            if ($noship->getId()) {
                $noship->addData($postData->getData());
            } else {
                $noship->setData($postData->getData());
                $noship->setCreationTime(now());
            }

            $noship->save();
                
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The no ship has been saved.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if($this->getRequest()->getParam('continue')) {
            $this->_redirect('*/*/edit', array('id' => $noship->getId()));
        } else {
            $this->_redirect('*/*');
        }
    }

    public function deleteAction()
    {
        try {
            $noship = $this->_initNoship(true);

            $noship->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The no ship has been deleted.'));
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*');
    }

}