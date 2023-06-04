<?php

namespace WhiteApp\Shopfinder\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use WhiteApp\Shopfinder\Api\ShopRepositoryInterface;
use WhiteApp\Shopfinder\Model\ResourceModel\Shop as ShopResource;

class ShopRepository implements ShopRepositoryInterface
{
    protected $shopResource;
    protected $shopFactory;
    private $randomFactory;

    public function __construct(
        ShopResource $shopResource,
        ShopFactory $shopFactory,
        RandomFactory $randomFactory
    ) {
        $this->shopResource = $shopResource;
        $this->shopFactory = $shopFactory;
        $this->randomFactory = $randomFactory;
    }

    public function getShops()
    {
        // Logic to fetch all shops
        return $this->shopResource->getShops();
    }

    public function getShopByIdentifier($identifier)
    {
        // Logic to fetch a shop by identifier
        return $this->shopResource->getShopByIdentifier($identifier);
    }

    public function updateShop($data)
    {
        $shopId = $data['shop_id'];
        try {
            $shop = $this->shopFactory->create()->load($shopId);
            if (!$shop->getId()) {
                throw new NoSuchEntityException(__('The shop with the given ID does not exist.'));
            }

            // Update shop data
            $shop->setName($data['name']);
            $shop->setCountry($data['country']);
            $shop->setImage($data['image']);
            $shop->setLongitude($data['longitude']);
            $shop->setLatitude($data['latitude']);

            $this->shopResource->save($shop);
            return $shop;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    public function deleteShop($shopId)
    {
        throw new CouldNotDeleteException(__('Deleting shops via the API is not allowed.'));
    }

    public function getNearbyShops($latitude, $longitude, $radius)
    {
        // Implement the logic to fetch shops near the given location within the specified radius
        // You can use the latitude, longitude, and radius to query the shops from your data source

        $shops = $this->shopResource->getShops();
        $nearbyShops = [];
        foreach ($shops as $shop) {
            $distance = $this->calculateDistance($latitude, $longitude, $shop->getLatitude(), $shop->getLongitude());
            if ($distance <= $radius) {
                $nearbyShops[] = $shop;
            }
        }

        return $nearbyShops;
    }

    private function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {

        // Using the Haversine formula to calculate the distance between two points on the Earth's surface
        $earthRadius = 6371; // Earth's radius in kilometers

        // Convert degrees to radians
        $lat1 = deg2rad($latitude1);
        $lon1 = deg2rad($longitude1);
        $lat2 = deg2rad($latitude2);
        $lon2 = deg2rad($longitude2);

        // Calculate the differences between the latitudes and longitudes
        $latDiff = $lat2 - $lat1;
        $lonDiff = $lon2 - $lon1;

        // Apply the Haversine formula
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($lat1) * cos($lat2) * sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

}
