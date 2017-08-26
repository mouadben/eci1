<?php

class Eci_Ecishipping_Block_Adminhtml_Method_Widget_Grid_Column_Renderer_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Checkbox
{

    protected function _getCheckboxHtml($value, $checked)
    {
        return '<input type="hidden" name="'.$this->getColumn()->getName().'[displayed][]" value="' . $value . '"/>
            <input type="checkbox" name="'.$this->getColumn()->getName().'[checked][]" value="' . $value . '" class="'. ($this->getColumn()->getInlineCss() ? $this->getColumn()->getInlineCss() : 'checkbox' ).'"'.$checked.$this->getDisabled().'/>';
    }

    public function renderHeader()
    {
        if($this->getColumn()->getHeader()) {
            return parent::renderHeader();
        }

        $checked = '';
        if ($filter = $this->getColumn()->getFilter()) {
            $checked = $filter->getValue() ? ' checked="checked"' : '';
        }

        $disabled = '';
        if ($this->getColumn()->getDisabled()) {
            $disabled = ' disabled="disabled"';
        }
        return '<input type="checkbox" name="'.$this->getColumn()->getName().'[checked][]" onclick="'.$this->getColumn()->getGrid()->getJsObjectName().'.checkCheckboxes(this)" class="checkbox"'.$checked.$disabled.' title="'.Mage::helper('adminhtml')->__('Select All').'"/>';
    }

    
}
