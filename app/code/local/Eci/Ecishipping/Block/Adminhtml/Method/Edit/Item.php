<?php

class Eci_Ecishipping_Block_Adminhtml_Method_Edit_Item extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();

        $this->setId('itemGrid');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('assigned_item_ids' => 1));
        $this->setColumnRenderers(array('checkbox' => 'ecishipping/adminhtml_method_widget_grid_column_renderer_checkbox'));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/item')->getCollection();

        $this->setCollection($collection);

        parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'assigned_item_ids') {

            $assignedItemIds = $this->getAssignedItemIds();

            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('item_id', array('in' => $assignedItemIds));
            } else {
                $this->getCollection()->addFieldToFilter('item_id', array('nin' => $assignedItemIds));
            }
        }

        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareColumns()
    {
        $this->addColumn('assigned_item_ids', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'assigned_item_ids',
            'values' => $this->getAssignedItemIds(),
            'align' => 'center',
            'index' => 'item_id',
        ));

        $this->addColumn('code_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Code MwSt. 19%'),
            'index' => 'code_mwsth',
            'width' => '100px',
        ));

        $this->addColumn('cost_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Cost MwSt. 19%'),
            'index' => 'cost_mwsth',
            'type'  => 'currency',
            'width' => '100px',
        ));

        $this->addColumn('title_mwsth', array(
            'header' => Mage::helper('ecishipping')->__('Title MwSt. 19%'),
            'index' => 'title_mwsth',
            'width' => '250px',
        ));

        $this->addColumn('code_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Code MwSt. 7%'),
            'index' => 'code_mwstl',
            'width' => '100px',
        ));

        $this->addColumn('cost_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Cost MwSt. 7%'),
            'index' => 'cost_mwstl',
            'type'  => 'currency',
            'width' => '100px',
        ));

        $this->addColumn('title_mwstl', array(
            'header' => Mage::helper('ecishipping')->__('Title MwSt. 7%'),
            'index' => 'title_mwstl',
            'width' => '250px',
        ));

        $this->addColumn('surcharge_type', array(
            'header' => Mage::helper('ecishipping')->__('Surcharge Type'),
            'type' => 'options',
            'options' => Eci_Ecishipping_Model_Item::getSurchargeTypeOptions(),
            'index' => 'surcharge_type',
            'width' => '150px',
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('ecishipping')->__('Description'),
            'index' => 'description',
        ));

        return parent::_prepareColumns();
    }

    public function getAssignedItemIds()
    {
        return Mage::registry('ecishipping_method')->getItems();
    }
    
}

