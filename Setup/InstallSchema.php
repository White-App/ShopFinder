<?php

namespace Whiteapp\ShopFinder\Setup;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        if (!$installer->tableExists('shopfinder')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('shopfinder')
            )->addColumn(
                    'shopfinder_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'shopfinder ID'
                )->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Title'
                )->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullable' => false],
                    'Post'
                )->addColumn(
                    'address',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullable' => false],
                    'Address'
                )->addColumn(
                    'zoomlevel',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false , 'default' => '12'],
                    'Zoom Level'
                )->addColumn(
                    'latitude',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Latitude'
                )->addColumn(
                    'longitude',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Longitude'
                )
                ->addColumn(
                    'is_active',
                    Table::TYPE_SMALLINT,
                    null,
                    [],
                    'Active Status'
                )->setComment(
                    'ShopFinder Table'
                );
            $installer->getConnection()->createTable($table);

        }
        $installer->endSetup();

    }
}
