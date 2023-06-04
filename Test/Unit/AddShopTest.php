<?php

namespace WhiteApp\Shopfinder\Test\Unit;

use PHPUnit\Framework\TestCase;
use WhiteApp\Shopfinder\Model\Shop;
use WhiteApp\Shopfinder\Model\ShopRepository;

class ShopTest extends TestCase
{
    public function testAddShopSuccess()
    {
        $shopRepository = $this->createMock(ShopRepository::class);
        $shopRepository->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $shop = new Shop($shopRepository);

        $shopData = [
            'name' => 'Shop Name',
            'identifier' => 'shop-identifier',
            'country' => 'Country',
            'image' => 'path/to/image.jpg',
            'longitude' => '123.456',
            'latitude' => '78.910',
        ];

        $result = $shop->addShop($shopData);

        // Assert the shop is added successfully
        $this->assertTrue($result);
    }
}
