<?php

namespace WhiteApp\Shopfinder\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Container;

class Shop extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_shop';
        $this->_blockGroup = 'WhiteApp_Shopfinder';
        $this->_headerText = __('Shopfinder');
        $this->_addButtonLabel = __('Add New Shop');
        parent::_construct();
    }
}
