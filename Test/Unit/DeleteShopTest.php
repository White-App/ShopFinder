<?php

namespace WhiteApp\Shopfinder\Test\Unit;

use PHPUnit\Framework\TestCase;
use WhiteApp\Shopfinder\Model\Shop;
use WhiteApp\Shopfinder\Model\ShopRepository;

class DeleteShopTest extends TestCase
{
    public function testDeleteShopRestricted()
    {
        $shopRepository = $this->getMockBuilder(ShopRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $shop = new Shop($shopRepository);

        $existingShopData = [
            'shop_id' => 1,
            'name' => 'Existing Shop',
            'identifier' => 'existing-shop',
            'country' => 'Country',
            'image' => 'path/to/image.jpg',
            'longitude' => '123.456',
            'latitude' => '78.910',
        ];

        // Assert that the deletion is restricted and throws an exception or returns an error response
        $this->expectException(\Exception::class);
        $shop->deleteShop($existingShopData);
    }
}
