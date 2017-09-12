<?php

namespace Amedical\Theme\Plugin\Checkout;


class LayoutProcessor
{
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
        $jsLayout = $this->getBillingFormFields($jsLayout);
        $jsLayout = $this->getShippingFormFields($jsLayout);
        return $jsLayout;
    }

    public function getShippingFormFields($jsLayout){
        if(isset($jsLayout['components']['checkout']['children']['steps']['children']
            ['shipping-step']['children']['shippingAddress']['children']
            ['shipping-address-fieldset'])
        ){

            $shippingPostcodeFields = $this->getFields('shippingAddress.custom_attributes','shipping');

            $shippingFields = $jsLayout['components']['checkout']['children']['steps']['children']
            ['shipping-step']['children']['shippingAddress']['children']
            ['shipping-address-fieldset']['children'];

            if(isset($shippingFields['street'])){
                unset($shippingFields['street']['children'][1]['validation']);
                unset($shippingFields['street']['children'][2]['validation']);
            }

            $shippingFields = array_replace_recursive($shippingFields,$shippingPostcodeFields);

            $jsLayout['components']['checkout']['children']['steps']['children']
            ['shipping-step']['children']['shippingAddress']['children']
            ['shipping-address-fieldset']['children'] = $shippingFields;

        }

        return $jsLayout;
    }

    public function getBillingFormFields($jsLayout){
        if(isset($jsLayout['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['payments-list'])) {

            $paymentForms = $jsLayout['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['payments-list']['children'];

            foreach ($paymentForms as $paymentMethodForm => $paymentMethodValue) {

                $paymentMethodCode = str_replace('-form', '', $paymentMethodForm);

                if (!isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$paymentMethodCode . '-form'])) {
                    continue;
                }

                $billingFields = $jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']
                ['payments-list']['children'][$paymentMethodCode . '-form']['children']['form-fields']['children'];

                $billingPostcodeFields = $this->getFields('billingAddress' . $paymentMethodCode . '.custom_attributes', 'billing');

                $billingFields = array_replace_recursive($billingFields, $billingPostcodeFields);

                $jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']
                ['payments-list']['children'][$paymentMethodCode . '-form']['children']['form-fields']['children'] = $billingFields;
            }
        }

        return $jsLayout;
    }

    public function getAdditionalFields($scope, $addressType){

        $fields = null;

        switch ($addressType) {
            case 'shipping':
                $fields = [
                    'bank_name' => [
                        'component' => 'Magento_Ui/js/form/element/abstract',
                        'config' => [
                            'customScope' => $scope,
                            'customEntry' => null,
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/input',
                        ],
                        'dataScope' => $scope . '.bank_name',
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
                            'customScope' => $scope,
                            'customEntry' => null,
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/input',
                        ],
                        'dataScope' => $scope . '.bank_account',
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
                break;

            case 'billing':
                $fields = [
                    'bank_name' => [
                        'component' => 'Magento_Ui/js/form/element/abstract',
                        'config' => [
                            'customScope' => $scope,
                            'customEntry' => null,
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/input',
                        ],
                        'dataScope' => $scope . '.bank_name',
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
                            'customScope' => $scope,
                            'customEntry' => null,
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/input',
                        ],
                        'dataScope' => $scope . '.bank_account',
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
                break;
        }

        return $fields;
    }

    public function getFields($scope, $addressType)
    {
        $fields = [];
        foreach($this->getAdditionalFields($scope, $addressType) as $field => $options) {
            $fields[$field] = $options;
        }
        return $fields;
    }
}