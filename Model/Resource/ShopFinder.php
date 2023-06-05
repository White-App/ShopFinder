<?php

namespace Whiteapp\ShopFinder\Model\Resource;

class ShopFinder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('shopfinder', 'shopfinder_id');
    }

    public function getShops()
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable());

        var_dump($select);
        exit();
        return $connection->fetchAll($select);
    }

    public function getShopByIdentifier($identifier)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('identifier = ?', $identifier);

        return $connection->fetchRow($select);
    }

    public function updateShop($data)
    {
        $connection = $this->getConnection();
        $connection->update(
            $this->getMainTable(),
            $data,
            ['shopfinder_id = ?' => $data['shopfinder_id']]
        );
    }

    public function deleteShop($shopId)
    {
        $connection = $this->getConnection();
        $connection->delete(
            $this->getMainTable(),
            ['shopfinder_id = ?' => $shopId]
        );
    }


}
?>
