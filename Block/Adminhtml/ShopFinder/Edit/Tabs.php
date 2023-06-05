<?php
namespace Whiteapp\ShopFinder\Block\Adminhtml\ShopFinder\Edit;

/**
 * Admin page left menu
 */
 /**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('shopfinder_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Store Information'));
    }
}
