<?php
namespace Upgradeschmiede\Manufacturer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Create manufacturer table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('upgradeschmiede_manufacturer')
        )->addColumn(
            'manufacturer_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Manufacturer ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Description'
        )->addColumn(
            'url',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'URL'
        )->addColumn(
            'logo',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Logo'
        )->addColumn(
            'anschrift',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Anschrift'
        )->addColumn(
            'bestell_mail',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Bestell Mail'
        )->addColumn(
            'muster_mail',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Muster Mail'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->setComment(
            'Hersteller Table'
        );

        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}