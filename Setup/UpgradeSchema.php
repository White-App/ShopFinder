<?php

namespace WhiteApp\Shopfinder\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            // Perform schema changes for version 1.0.1
            $this->addNewColumn($installer);
        }

        $installer->endSetup();
    }

    protected function addNewColumn($installer)
    {
        $installer->getConnection()->addColumn(
            $installer->getTable('whiteapp_shopfinder_shop'),
            'new_column',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'New Column',
            ]
        );
    }
}
