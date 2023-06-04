<?php

namespace WhiteApp\Shopfinder\Test\Unit;

use PHPUnit\Framework\TestCase;
use WhiteApp\Shopfinder\Model\Shop;
use WhiteApp\Shopfinder\Model\ShopRepository;

class EditShopTest extends TestCase
{
    public function testEditShopSuccess()
    {
        // Mock the ShopRepository
        $shopRepository = $this->getMockBuilder(ShopRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $shop = new Shop($shopRepository);

        // Set up existing shop data
        $existingShopData = [
            'shop_id' => 1,
            'name' => 'Existing Shop',
            'identifier' => 'existing-shop',
            'country' => 'Country',
            'image' => 'path/to/image.jpg',
            'longitude' => '123.456',
            'latitude' => '78.910',
        ];

        // Set up the updated shop data
        $updatedShopData = [
            'shop_id' => 1,
            'name' => 'Updated Shop',
            'identifier' => 'updated-shop',
            'country' => 'New Country',
            'image' => 'path/to/updated-image.jpg',
            'longitude' => '987.654',
            'latitude' => '32.456',
        ];

        // Mock the save method of the ShopRepository to return true
        $shopRepository->expects($this->once())
            ->method('save')
            ->with($updatedShopData)
            ->willReturn(true);

        $result = $shop->editShop($updatedShopData);

        // Assert that the shop details are updated successfully
        $this->assertTrue($result);
    }
}
