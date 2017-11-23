<?php

namespace Amedical\Theme\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\DB\Ddl\Table;

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
                'position_occupation' => [
                    'label' => 'Position Occupation',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 1050,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
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
                    'used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout', 'customer_account_edit', 'customer_account_create', 'checkout_register'],
                ]);
                $attribute->save();
            }
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.3') < 0) {

            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributesInfo = [
                'bank_name' => [
                    'label' => 'Bank Name',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 65,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
                ],
                'bank_account' => [
                    'label' => 'Bank Account',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 66,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
                ]
            ];
            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();
            /** @var $attributeSet AttributeSet */
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
            foreach ($attributesInfo as $attributeCode => $attributeParams) {
                $customerSetup->addAttribute('customer_address', $attributeCode, $attributeParams);

                $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', $attributeCode);
                $attribute->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address'],
                ]);
                $attribute->save();
            }
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.4') < 0) {

//            Add address fields
            $tableNames = [
                'customer_address_entity',
                'quote_address',
                'sales_order_address'
            ];

            $columns = [
                'bank_name' => [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'length' => 255,
                    'comment' => 'Bank Name',
                ],
                'bank_account' => [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'length' => 255,
                    'comment' => 'Bank Account',
                ]
            ];

            $this->addColumnsMass($tableNames, $columns, $setup->getConnection());

            //        Add customer fields
            $tableNames = [
                'sales_order',
                'quote'
            ];

            $columns = [
                'position_occupation' => [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'length' => 255,
                    'comment' => 'Customer Position Occupation',
                ],
                'customer_group' => [
                    'type' => Table::TYPE_INTEGER,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Customer Group',
                ]
            ];

            $this->addColumnsMass($tableNames, $columns, $setup->getConnection());
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.5') < 0) {

            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributesInfo = [
                'company' => [
                    'label' => 'Company',
                    'type' => 'varchar',
                    'input' => 'text',
                    'position' => 1040,
                    'visible' => true,
                    'required' => false,
                    'system' => 0,
                    'user_defined' => true,
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
                    'used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout', 'customer_account_edit', 'customer_account_create', 'checkout_register'],
                ]);
                $attribute->save();
            }
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.6') < 0) {
            $connection = $setup->getConnection();
//            $connection->changeColumn(
//                'sales_order',
//                'customer_group',
//                'customer_group_assign',
//                [
//                    'type' => Table::TYPE_INTEGER,
//                    'nullable' => true,
//                    'default' => null,
//                    'comment' => 'Assign to Customer Group ID',
//                ]
//            );
//
//            $connection->changeColumn(
//                'quote',
//                'customer_group',
//                'customer_group_assign',
//                [
//                    'type' => Table::TYPE_INTEGER,
//                    'nullable' => true,
//                    'default' => null,
//                    'comment' => 'Assign to Customer Group ID',
//                ]
//            );
//
//            $connection->changeColumn(
//                'sales_order',
//                'position_occupation',
//                'customer_position_occupation',
//                [
//                    'type' => Table::TYPE_TEXT,
//                    'nullable' => true,
//                    'default' => null,
//                    'length' => 255,
//                    'comment' => 'Customer Position Occupation',
//                ]
//            );
//
//            $connection->changeColumn(
//                'quote',
//                'position_occupation',
//                'customer_position_occupation',
//                [
//                    'type' => Table::TYPE_TEXT,
//                    'nullable' => true,
//                    'default' => null,
//                    'length' => 255,
//                    'comment' => 'Customer Position Occupation',
//                ]
//            );
//
//            $connection->dropColumn('customer_address_entity', 'bank_name');
//            $connection->dropColumn('customer_address_entity', 'bank_account');

            $connection->dropColumn('quote', 'customer_position_occupation');
            $connection->dropColumn('quote', 'customer_group_assign');
        }

        $setup->endSetup();
    }

    private function addColumnsMass($tableNames, $columns, $connection)
    {
        foreach ($tableNames as $tableName) {
            foreach ($columns as $name => $definition) {
                $connection->addColumn($tableName, $name, $definition);
            }
        }
    }
}