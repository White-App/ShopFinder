<?php

namespace WhiteApp\Shopfinder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Shop extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('whiteapp_shopfinder', 'shop_id');
    }
}
