<?php

namespace WhiteApp\Shopfinder\Api;

interface ShopRepositoryInterface
{
    /**
     * Retrieve all shops
     *
     * @return \WhiteApp\Shopfinder\Api\Data\ShopInterface[]
     */
    public function getShops();

    /**
     * Retrieve shop by identifier
     *
     * @param string $identifier
     * @return \WhiteApp\Shopfinder\Api\Data\ShopInterface|null
     */
    public function getShopByIdentifier($identifier);

    /**
     * Update a shop
     *
     * @param array $data
     * @return \WhiteApp\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function updateShop($data);

    /**
     * Delete a shop by ID
     *
     * @param int $shopId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteShop($shopId);

    /**
     * Retrieve shops near a given location within the specified radius
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $radius
     * @return \WhiteApp\Shopfinder\Api\Data\ShopInterface[]
     */
    public function getNearbyShops($latitude, $longitude, $radius);

}
