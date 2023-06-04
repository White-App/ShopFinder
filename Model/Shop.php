<?php

namespace WhiteApp\Shopfinder\Model;

use Magento\Framework\Model\AbstractModel;
use WhiteApp\Shopfinder\Model\ResourceModel\Shop as ShopResource;

class Shop extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ShopResource::class);
    }
}
