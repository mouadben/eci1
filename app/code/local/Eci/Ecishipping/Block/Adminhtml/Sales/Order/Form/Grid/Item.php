<?php

class Eci_Ecishipping_Block_Adminhtml_Sales_Order_Form_Grid_Item extends Mage_Adminhtml_Block_Widget_Grid
{

    public function getTemplate()
    {
        return 'ecishipping/order/create/grid.phtml';
    }

    public function __construct()
    {
        parent::__construct();
        $this->setId('ecishipping_itemgrid');
        $this->setDefaultLimit(5);
        $this->setUseAjax(true);
        $this->setRowClickCallback('ecishipping.shippingGridRowClick.bind(ecishipping)');
        $this->setCheckboxCheckCallback('ecishipping.shippingItemGridCheckboxCheck.bind(ecishipping)');
        $this->setDefaultFilter(array('assigned_item_ids' => 1));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecishipping/item')
            ->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
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
        $taxFieldSuffix = $this->_getTaxFieldSuffix();

        $this->addColumn('assigned_item_ids', array(
            'type' => 'checkbox',
            'values' => $this->getAssignedItemIds(),
            'align' => 'center',
            'index' => 'item_id',
            'header' => ' ',
            'width' => '60px',
        ));

        $this->addColumn('code', array(
            'header' => Mage::helper('ecishipping')->__('Code'),
            'index' => 'code'.$taxFieldSuffix,
            'width' => '100px',
        ));

        $this->addColumn('cost', array(
            'header' => Mage::helper('ecishipping')->__('Cost'),
            'index' => 'cost'.$taxFieldSuffix,
            'width' => '100px',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('ecishipping')->__('Title'),
            'index' => 'title'.$taxFieldSuffix,
            'width' => '250px',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        if ($this->getSalesOrder()) {
            return $this->getUrl('*/ecishipping_shipping/itemgrid/', array('so' => $this->getSalesOrder()->getId()));
        }

        return $this->getUrl('*/ecishipping_shipping/itemgrid/');
    }

    public function getAssignedItemIds()
    {
        if (!$this->hasData('assigned_item_ids')) {
            $assignedItems = array();

            if ($this->getSalesOrder() && $this->getSalesOrder()->getItems() instanceof Varien_Data_Collection) {
                foreach ($this->getSalesOrder()->getItems() as $item) {
                    $assignedItems[] = $item->getId();
                }
            }

            $this->setData('assigned_item_ids', $assignedItems);
        }

        return $this->getData('assigned_item_ids');
    }

    /**
     * @return string
     */
    protected function _getTaxFieldSuffix()
    {
        if ($this->getSalesOrder() && $this->getSalesOrder()->getTaxFieldSuffix()) {
            return $this->getSalesOrder()->getTaxFieldSuffix();
        }

        return Eci_Ecishipping_Helper_Data::TAX_FIELD_SUFFIX_19;
    }

}

