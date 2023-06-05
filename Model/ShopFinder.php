<?php
namespace Whiteapp\ShopFinder\Model;

class ShopFinder extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Whiteapp\ShopFinder\Model\Resource\ShopFinder');
    }
}
?>
