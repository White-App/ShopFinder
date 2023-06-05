<?php
namespace Whiteapp\ShopFinder\Model\Resource\ShopFinder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Whiteapp\ShopFinder\Model\ShopFinder', 'Whiteapp\ShopFinder\Model\Resource\ShopFinder');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
