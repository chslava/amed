<?php

namespace Amedical\Theme\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
{
    public function process($jsLayout)
    {
        /*

        $customFields = [
            'bank_name' => [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'currentBillingAddress.custom_attributes',
                    'customEntry' => null,
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                ],
                'dataScope' => 'currentBillingAddress.custom_attributes.bank_name',
                'label' => 'Bank Name',
                'provider' => 'checkoutProvider',
                'sortOrder' => 65,
                'validation' => [
                    'required-entry' => false
                ],
                'options' => [],
                'filterBy' => null,
                'customEntry' => null,
                'visible' => true,
            ],
            'bank_account' => [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'currentBillingAddress.custom_attributes',
                    'customEntry' => null,
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                ],
                'dataScope' => 'currentBillingAddress.custom_attributes.bank_account',
                'label' => 'Bank Account',
                'provider' => 'checkoutProvider',
                'sortOrder' => 66,
                'validation' => [
                    'required-entry' => false
                ],
                'options' => [],
                'filterBy' => null,
                'customEntry' => null,
                'visible' => true,
            ]
        ];

        foreach ($customFields as $attributeCode => $field ) {
            $jsLayout['components']
            ['checkout']['children']
            ['steps']['children']
            ['billing-step']['children']
            ['payment']['children']
            ['payments-list']['children']
            ['free-form']['children']
            ['form-fields']['children'][$attributeCode] = $field;
        }

//        $configuration = $jsLayout['components']
//                ['checkout']['children']
//                ['steps']['children']
//                ['billing-step']['children']
//                ['payment']['children']
//                ['payments-list']['children'];
//
//        foreach ($configuration as $paymentGroup => $groupConfig) {
//            if (isset($groupConfig['component']) && $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {
//                foreach ($customFields as $attributeCode => $field ) {
//                    $jsLayout['components']
//                            ['checkout']['children']
//                            ['steps']['children']
//                            ['billing-step']['children']
//                            ['payment']['children']
//                            ['payments-list']['children']
//                            [$paymentGroup]['children']
//                            ['form-fields']['children']
//                            [$attributeCode] = $field;
//                }
//            }
//        }
*/
        $jsLayout = $this->getShippingFormFields($jsLayout);
        $jsLayout = $this->getBillingFormFields($jsLayout);
        return $jsLayout;
    }

    public function getShippingFormFields($jsLayout)
    {
        $customFields = [
            'bank_name' => [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress.custom_attributes',
                    'customEntry' => null,
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                ],
                'dataScope' => 'shippingAddress.custom_attributes.bank_name',
                'label' => 'Bank Name',
                'provider' => 'checkoutProvider',
                'sortOrder' => 65,
                'validation' => [
                    'required-entry' => false
                ],
                'options' => [],
                'filterBy' => null,
                'customEntry' => null,
                'visible' => true,
            ],
            'bank_account' => [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress.custom_attributes',
                    'customEntry' => null,
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                ],
                'dataScope' => 'shippingAddress.custom_attributes.bank_account',
                'label' => 'Bank Account',
                'provider' => 'checkoutProvider',
                'sortOrder' => 66,
                'validation' => [
                    'required-entry' => false
                ],
                'options' => [],
                'filterBy' => null,
                'customEntry' => null,
                'visible' => true,
            ]
        ];

        foreach ($customFields as $attributeCode => $field ) {
            $jsLayout['components']
            ['checkout']['children']
            ['steps']['children']
            ['shipping-step']['children']
            ['shippingAddress']['children']
            ['shipping-address-fieldset']['children']
            [$attributeCode] = $field;
        }

        return $jsLayout;
    }

    public function getBillingFormFields($jsLayout)
    {
        if(isset($jsLayout['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['payments-list'])) {
            $paymentForms = $jsLayout['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['payments-list']['children'];
        }

        return $jsLayout;
    }
}