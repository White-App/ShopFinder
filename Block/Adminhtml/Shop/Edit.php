<?php

namespace WhiteApp\Shopfinder\Block\Adminhtml\Shop;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    protected function _construct()
    {
        $this->_objectId = 'shop_id';
        $this->_blockGroup = 'WhiteApp_Shopfinder';
        $this->_controller = 'adminhtml_shop';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Shop'));
        $this->buttonList->update('delete', 'label', __('Delete Shop'));
    }
}
