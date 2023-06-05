<?php

namespace WhiteApp\Shopfinder\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use WhiteApp\Shopfinder\Api\ShopRepositoryInterface;
use WhiteApp\Shopfinder\Model\Resource\ShopFinder;

class ShopRepository implements ShopRepositoryInterface
{
    protected ShopFinder $shopFinder;
    protected ShopFinderFactory $shopFactory;

    public function __construct(
        ShopFinder $shopFinder,
        ShopFinderFactory $shopFactory
    ) {
        $this->shopFinder = $shopFinder;
        $this->shopFactory = $shopFactory;
    }

    public function getShops()
    {
        // Logic to fetch all shops
        return $this->shopFinder->getShops();
    }

    public function getShopByIdentifier($identifier)
    {
        // Logic to fetch a shop by identifier
        return $this->shopFinder->getShopByIdentifier($identifier);
    }

    public function updateShop($data)
    {
        $shopId = $data['shopfinder_id'];
        try {
            $shop = $this->shopFactory->create()->load($shopId);
            if (!$shop->getId()) {
                throw new NoSuchEntityException(__('The shop with the given ID does not exist.'));
            }

            // Update shop data
            $shop->setTitle($data['title']);
            $shop->setAddress($data['address']);
            $shop->setCountry($data['country']);
            $shop->setIsActive($data['is_active']);
            $shop->setLongitude($data['longitude']);
            $shop->setLatitude($data['latitude']);

            $this->shopFinder->save($shop);
            return $shop;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    public function deleteShop($shopId)
    {
        try {
            // Assuming you have a shopRepository with a deleteById method.
            $this->shopRepository->deleteById($shopId);
            return ['success' => true, 'message' => 'Shop deleted successfully.'];
        } catch (\Exception $e) {
            // Log the exception and return a result to indicate failure.
            $this->logger->error($e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete shop.'];
        }
    }


    public function getNearbyShops($latitude, $longitude, $radius)
    {
        // Implement the logic to fetch shops near the given location within the specified radius
        // You can use the latitude, longitude, and radius to query the shops from your data source

        $shops = $this->shopFinder->getShops();
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
