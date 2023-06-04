<?php

namespace WhiteApp\Shopfinder\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    private $menuFactory;

    public function __construct(\Magento\Backend\Model\Menu\Factory $menuFactory)
    {
        $this->menuFactory = $menuFactory;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('whiteapp_shopfinder')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('whiteapp_shopfinder')
            )
                ->addColumn(
                    'shop_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Shop ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Shop Name'
                )
                ->addColumn(
                    'identifier',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Shop Identifier'
                )
                ->addColumn(
                    'country',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Shop Country'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Shop Image'
                )
                ->addColumn(
                    'longitude',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Shop Longitude'
                )
                ->addColumn(
                    'latitude',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Shop Latitude'
                )
                ->setComment('Shopfinder Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('whiteapp_shopfinder'),
                $setup->getIdxName(
                    $installer->getTable('whiteapp_shopfinder'),
                    ['name', 'identifier', 'country', 'image', 'longitude', 'latitude'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'identifier', 'country', 'image', 'longitude', 'latitude'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        // Create the menu
        $this->addMenu();

        $installer->endSetup();
    }

    private function addMenu()
    {
        $menu = $this->menuFactory->create();
        $menu->setData([
            'parent_id' => 'Magento_Catalog::catalog',
            'id' => 'WhiteApp_Shopfinder::shopfinder',
            'title' => 'Shopfinder',
            'module' => 'WhiteApp_Shopfinder',
            'resource' => 'WhiteApp_Shopfinder::shopfinder',
            'sort_order' => 30,
            'action' => 'shopfinder/shop/index',
        ]);
        $menu->save();
    }
}
