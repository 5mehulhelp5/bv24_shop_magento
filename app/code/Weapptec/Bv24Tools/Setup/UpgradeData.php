<?php

namespace Weapptec\Bv24Tools\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'bv24_file_id',
                [
                    'type' => 'int',
                    'label' => 'BV24 Datei',
                    'input' => 'text', // wichtig: kein select!
                    'required' => false,
                    'sort_order' => 100,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'user_defined' => true,
                    'group' => 'General',
                    'visible_on_front' => false,
                ]
            );
        }

        $setup->endSetup();
    }
}
