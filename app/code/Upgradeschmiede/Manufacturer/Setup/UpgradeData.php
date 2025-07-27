<?php
namespace Upgradeschmiede\Manufacturer\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;

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

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            
            // Check if attribute already exists
            $attributeId = $eavSetup->getAttributeId(Product::ENTITY, 'manufacturer');
            
            if (!$attributeId) {
                $eavSetup->addAttribute(
                    Product::ENTITY,
                    'manufacturer',
                    [
                        'type' => 'int',
                        'label' => 'Hersteller',
                        'input' => 'select',
                        'source' => 'Upgradeschmiede\Manufacturer\Model\Attribute\Source\Manufacturer',
                        'required' => false,
                        'sort_order' => 30,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General',
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => true,
                        'is_filterable_in_grid' => true,
                        'visible' => true,
                        'is_html_allowed_on_frontend' => false,
                        'visible_on_front' => true,
                        'used_in_product_listing' => true,
                        'user_defined' => true
                    ]
                );
            }
        }

        $setup->endSetup();
    }
}