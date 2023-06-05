<?php

namespace Whiteapp\ShopFinder\Block\Adminhtml\ShopFinder\Edit;

/**
 * Adminhtml shopfinder edit form block
 *
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('whiteapp_shopfinder_form');
        $this->setTitle(__('Store Information'));
    }


    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form','enctype'=>'multipart/form-data' ,'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
