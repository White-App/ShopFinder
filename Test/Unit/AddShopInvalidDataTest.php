<?php

namespace WhiteApp\Shopfinder\Test\Unit;

use PHPUnit\Framework\TestCase;
use WhiteApp\Shopfinder\Model\Shop;
use WhiteApp\Shopfinder\Model\ShopRepository;

class ShopTest extends TestCase
{
    public function testAddShopInvalidData()
    {
        $shopRepository = $this->createMock(ShopRepository::class);
        $shopRepository->expects($this->never())
            ->method('save');

        $shop = new Shop($shopRepository);

        // Fill in invalid shop details (e.g., missing required fields)
        $shopData = [
            'name' => 'Shop Name',
            'identifier' => '',
            'country' => 'Country',
            'image' => 'path/to/image.jpg',
            'longitude' => '',
            'latitude' => '',
        ];

        $result = $shop->addShop($shopData);

        // Assert the shop is not added
        $this->assertFalse($result);
    }
}
