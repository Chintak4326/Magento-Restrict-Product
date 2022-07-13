<?php

namespace ChintakExtensions\ProductRestrict\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    private $eavSetupFactory;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            // This is the product attribute id
            'customer_group',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Restrict Customer Group',
                'input' => 'multiselect',
                'source' => 'ChintakExtensions\ProductRestrict\Model\Attribute\Source\CustomerGroup',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'required' => false,
                'sort_order' => 80,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE
            ]
        );
    }
}