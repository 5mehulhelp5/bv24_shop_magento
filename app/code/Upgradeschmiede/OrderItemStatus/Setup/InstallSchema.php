<?php
namespace Upgradeschmiede\OrderItemStatus\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Check if column doesn't exist before adding
        $connection = $installer->getConnection();
        $tableName = $installer->getTable('sales_order_item');
        
        if (!$connection->tableColumnExists($tableName, 'custom_status')) {
            $connection->addColumn(
                $tableName,
                'custom_status',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 50,
                    'nullable' => true,
                    'default' => 'offen',
                    'comment' => 'Order Item Custom Status'
                ]
            );
            
            // Add index for better performance
            $connection->addIndex(
                $tableName,
                $installer->getIdxName('sales_order_item', ['custom_status']),
                ['custom_status']
            );
        }

        $installer->endSetup();
    }
}