<?php

namespace Amedical\Theme\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;



    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.1') < 0) {

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'contact_person_name',
                [
                    'type' => 'text',
                    'label' => 'Contact Person Name',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 110,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'General Information',
                ]
            );

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'contact_person_phone',
                [
                    'type' => 'text',
                    'label' => 'Contact Person Phone',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 120,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'General Information',
                ]
            );
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.2') < 0) {

            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributesInfo = [
                'company_name' => [
                    'label' => 'Company Name',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 1000,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
                    'position' => 1000,
                ],
                'company_registration_number' => [
                    'label' => 'Company Registration Number',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 1050,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
                    'position' => 1050,
                ]
            ];
            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();
            /** @var $attributeSet AttributeSet */
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
            foreach ($attributesInfo as $attributeCode => $attributeParams) {
                $customerSetup->addAttribute(Customer::ENTITY, $attributeCode, $attributeParams);

                $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, $attributeCode);
                $attribute->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer', 'customer_account_edit', 'customer_account_create'],
                ]);
                $attribute->save();
            }
        }

        $setup->endSetup();
    }
}