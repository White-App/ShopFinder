<?php

namespace WhiteApp\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Add extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add New Shop'));
        $this->_setActiveMenu('WhiteApp_Shopfinder::shop');
        $resultPage->addBreadcrumb(__('Shopfinder'), __('Shopfinder'));
        $resultPage->addBreadcrumb(__('Manage Shops'), __('Manage Shops'));
        $resultPage->addBreadcrumb(__('Add New Shop'), __('Add New Shop'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WhiteApp_Shopfinder::shop_save');
    }
}
