<?php

namespace WhiteApp\Shopfinder\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use WhiteApp\Shopfinder\Model\ShopRepository;

class Shops implements ResolverInterface
{
    protected $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        switch ($field->getName()) {
            case 'getShops':
                return $this->getShops();
            case 'getShopByIdentifier':
                return $this->getShopByIdentifier($args['identifier']);
            case 'updateShop':
                return $this->updateShop($args);
            case 'deleteShop':
                throw new LocalizedException(__('Deleting shops via the API is not allowed.'));
            case 'getNearbyShops':
                return $this->getNearbyShops($args['latitude'], $args['longitude'], $args['radius']);
        }
        throw new LocalizedException(__('%1 cannot resolve the field %2', [static::class, $field->getName()]));
    }

    private function getNearbyShops($latitude, $longitude, $radius)
    {
        // Implement logic to fetch shops near the given location within the specified radius
        // You can use the latitude, longitude, and radius to query the shops from your data source
        // For simplicity, let's assume you have a method called `getNearbyShops` in your shop repository

        return $this->shopRepository->getNearbyShops($latitude, $longitude, $radius);
    }

    private function getShops()
    {
        return $this->shopRepository->getShops();
    }

    private function getShopByIdentifier($identifier)
    {
        return $this->shopRepository->getShopByIdentifier($identifier);
    }

    private function updateShop($args)
    {
        return $this->shopRepository->updateShop($args);
    }

    private function deleteShop($shopId)
    {
        return $this->shopRepository->deleteShop($shopId);
    }

}
