<?php

namespace WhiteApp\Shopfinder\Block\Adminhtml\Shop;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
