<?php
namespace Upgradeschmiede\OrderItemStatus\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrade schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            // Check if column exists before adding index
            $connection = $installer->getConnection();
            $tableName = $installer->getTable('sales_order_item');
            
            if ($connection->tableColumnExists($tableName, 'custom_status')) {
                // Add index for better performance
                $connection->addIndex(
                    $tableName,
                    $installer->getIdxName('sales_order_item', ['custom_status']),
                    ['custom_status']
                );
            }
        }

        $installer->endSetup();
    }
}