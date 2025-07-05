<?php
namespace Upgradeschmiede\Manufacturer\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddManufacturerAttribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'manufacturer_id',
            [
                'type' => 'int',
                'label' => 'Hersteller',
                'input' => 'multiselect',
                'required' => false,
                'sort_order' => 210,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => false,
                'user_defined' => true,
                'searchable' => true,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'source' => \Upgradeschmiede\Manufacturer\Model\Attribute\Source\Manufacturer::class,
                'group' => 'General'
            ]
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies() { return []; }
    public function getAliases() { return []; }
}
