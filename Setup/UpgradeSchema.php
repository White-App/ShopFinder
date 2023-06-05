<?php

namespace Whiteapp\ShopFinder\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('shopfinder'),
                'image',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 532,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Upload Image'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('shopfinder'),
                'country',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'comment' => 'Country'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('shopfinder'),
                'identifier',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'comment' => 'Unique Identifier'
                ]
            );
        }

        $setup->endSetup();
    }
}
