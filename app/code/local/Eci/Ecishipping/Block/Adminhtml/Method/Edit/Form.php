<?php

class Eci_Ecishipping_Block_Adminhtml_Method_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $method = Mage::registry('ecishipping_method');

        $form = new Varien_Data_Form(array(
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'id' => 'edit_form',
            'method' => 'post',
        ));

        if ($method->getId()) {

            if ($this->getRequest()->getParam('store')) {
                $method->setStore($this->getRequest()->getParam('store'));
            }

            $storeSwitcher = $this->getLayout()->createBlock('adminhtml/store_switcher');
            $storeSwitcher->setWebsiteIds($method->getWebsite());

            $form->addField('label_store', 'note', array(
                'text' => $storeSwitcher->toHtml(),
            ));

            $form->addField('store', 'hidden', array(
                'name' => 'store',
            ));
        }

        $fieldset = $form->addFieldset('method', array(
            'legend' => Mage::helper('ecishipping')->__('Method'),
        ));

        if ($method->getStore()) {
            $fieldset->addField('title', 'text', array(
                'name' => 'title',
                'label' => Mage::helper('ecishipping')->__('Title'),
            ));

            $fieldset->addField('description', 'textarea', array(
                'name' => 'description',
                'label' => Mage::helper('ecishipping')->__('Description'),
            ));
        } else {

            $fieldset->addField('is_active', 'select', array(
                'name' => 'is_active',
                'label' => Mage::helper('ecishipping')->__('Is Activ'),
                'values' => Eci_Ecishipping_Model_Method::getActiveOptions(),
            ));

            /*$fieldset->addField('tour', 'select', array(
                'name' => 'tour',
                'label' => Mage::helper('ecishipping')->__('Tour'),
                'required' => true,
                'values' => Mage::getModel('ogsource/tour')->toOptionArray(),
            ));*/
            
            $fieldset->addField('title', 'text', array(
                'name' => 'title',
                'label' => Mage::helper('ecishipping')->__('Title'),
                'required' => true,
            ));

            $fieldset->addField('description', 'textarea', array(
                'name' => 'description',
                'label' => Mage::helper('ecishipping')->__('Description'),
            ));

            $fieldset->addField('threshold_type', 'select', array(
                'name' => 'threshold_type',
                'label' => Mage::helper('ecishipping')->__('Threshold Type'),
                'required' => true,
                'values' => Eci_Ecishipping_Model_Method::getThresholdOptions(),
            ));

            $fieldset->addField('threshold_value', 'text', array(
                'name' => 'threshold_value',
                'label' => Mage::helper('ecishipping')->__('Threshold Value'),
                'required' => true,
            ));
            $fieldset->addField('threshold_value_second', 'text', array(
                'name' => 'threshold_value_second',
                'label' => Mage::helper('ecishipping')->__('Bis'),
                'required' => true,
            ));

            $fieldset->addField('website', 'multiselect', array(
                'name' => 'website',
                'label' => Mage::helper('ecishipping')->__('Allowed Websites'),
                'required' => true,
                'values' => Mage::getResourceModel('core/website_collection')->load()->toOptionArray(),
            ))->setSize(7);

            $fieldset->addField('country_specific', 'select', array(
                'name' => 'country_specific',
                'label' => Mage::helper('ecishipping')->__('Ship to Applicable Countries'),
                'required' => true,
                'values' => Mage::getModel('adminhtml/system_config_source_shipping_allspecificcountries')->toOptionArray(),
            ))->setSize(7);

            $fieldset->addField('country', 'multiselect', array(
                'name' => 'country',
                'label' => Mage::helper('ecishipping')->__('Allowed Delivery Countries'),
                'required' => true,
                'values' => Mage::getResourceModel('directory/country_collection')->loadData()->toOptionArray(false),
            ))->setSize(7);

            $fieldset->addField('customer_group_specific', 'select', array(
                'name' => 'customer_group_specific',
                'label' => Mage::helper('ecishipping')->__('Anwendbare kunden Gruppen'),
                'required' => true,
                'values' => Eci_Ecishipping_Model_Method::getKundenGruppenOptions(),
            ))->setSize(7);

            $fieldset->addField('customer_group', 'multiselect', array(
                'name' => 'customer_group',
                'label' => Mage::helper('ecishipping')->__('Allowed Kunden Gruppen'),
                'required' => true,
                'values' => Mage::getResourceModel('customer/group_collection')->loadData()->toOptionArray(true),
            ))->setSize(7);

            $fieldset->addField('threshold_zeit', 'text', array(
                'name' => 'threshold_zeit',
                'label' => Mage::helper('ecishipping')->__('Threshold Zeit'),
                'required' => false,
                'after_element_html' => "<small>".Mage::helper('ecishipping')->__('Ganze Zahl 1 bis 23.')."</small>"
            ));
            
            $fieldset->addField('freeship', 'select', array(
                'name' => 'freeship',
                'label' => Mage::helper('ecishipping')->__('Free Shipping'),
                'required' => true,
                'values' => Eci_Ecishipping_Model_Method::getFreeshipOptions(),
            ));
/*
            $fieldset->addField('exclusive_category', 'multiselect', array(
                'name' => 'exclusive_category',
                'label' => Mage::helper('ecishipping')->__('Exclusive Category'),
                'values' => Eci_Ecishipping_Model_Method::getProductGroupOptions(),
            ));*/

            $fieldset->addField('is_payondelivery', 'select', array(
                'name' => 'is_payondelivery',
                'label' => Mage::helper('ecishipping')->__('Is Pay On Delivery'),
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            ));

            $fieldset->addField('is_payonpick', 'select', array(
                'name' => 'is_payonpick',
                'label' => Mage::helper('ecishipping')->__('Is Pay On Pick'),
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            ));

            $fieldset->addField('sku_filter', 'select', array(
                'name' => 'sku_filter',
                'label' => Mage::helper('ecishipping')->__('für bestimmte Skus'),
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
            ));

            $fieldset->addField('sku_liste', 'textarea', array(
                'name' => 'sku_liste',
                'label' => Mage::helper('ecishipping')->__('Skus Liste'),
                'after_element_html' => "<small>"."<b><br/>Skus getrennt durch Sternchen<br/>bitte nicht vergessen Sternchen am Anfang und am Ende<br/> <span style='color:red;'>*</span>11111*22222*33333<span style='color:red;'>*</span></b></small>"
            ));

            $fieldset->addField('auftragsrabat_filter', 'select', array(
                'name' => 'auftragsrabat_filter',
                'label' => Mage::helper('ecishipping')->__('für bestimmte Auftragsrabat Ids'),
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
            ));

            $fieldset->addField('auftragsrabat_id', 'textarea', array(
                'name' => 'auftragsrabat_id',
                'label' => Mage::helper('ecishipping')->__('Auftragsrabat Ids'),
                'after_element_html' => "<small>"."<b><br/>Ids getrennt durch Komma<br/><span style='color:red;'>*</span>111,222,333<span style='color:red;'>*</span></b></small>"
            ));

            $fieldset = $form->addFieldset('delivery', array(
                'legend' => Mage::helper('ecishipping')->__('Delivery'),
            ));

            $fieldset->addField('delivery_day', 'multiselect', array(
                'name' => 'delivery_day',
                'label' => Mage::helper('ecishipping')->__('Allowed Delivery Days'),
                'required' => true,
                'values' => Eci_Ecishipping_Model_Method::getOptionWeekdays(),
            ))->setSize(7);

            $ressourceGrid = $this->getLayout()->createBlock("Eci_Ecishipping_Block_Adminhtml_Method_Edit_Item");

            $form->addFieldset('items', array(
                'legend' => Mage::helper('ecishipping')->__('Assigned Items'),
                'class' => 'fieldset-wide',
            ))->setHtmlContent($ressourceGrid->toHtml());

            $this->setChild('form_after', $this->getLayout()->createBlock('ecishipping/adminhtml_widget_form_element_dependence')
                ->addFieldMap('country', 'country')
                ->addFieldMap('country_specific', 'country_specific')
                ->addFieldMap('threshold_type', 'threshold_type')
                ->addFieldMap('threshold_value', 'threshold_value')
                ->addFieldMap('threshold_value_second', 'threshold_value_second')
                ->addFieldMap('customer_group_specific', 'customer_group_specific')
                ->addFieldMap('customer_group', 'customer_group')
                ->addFieldMap('sku_filter', 'sku_filter')
                ->addFieldMap('sku_liste', 'sku_liste')
                ->addFieldMap('auftragsrabat_filter', 'auftragsrabat_filter')
                ->addFieldMap('auftragsrabat_id', 'auftragsrabat_id')
                ->addFieldDependence('country', 'country_specific', '1')
                ->addFieldDependence('threshold_value', 'threshold_type', array('1', '2', '3', '4', '5', '6'))
                ->addFieldDependence('threshold_value_second', 'threshold_type', '6')
                ->addFieldDependence('customer_group', 'customer_group_specific', '1')
                ->addFieldDependence('sku_liste', 'sku_filter', '1')
                ->addFieldDependence('auftragsrabat_id', 'auftragsrabat_filter', '1')
            );
        }


        $form->setValues($method ? $method->getData() : null);
        $form->setUseContainer(true);
        $form->addFieldNameSuffix('method');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}