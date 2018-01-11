<?php

namespace Amedical\Theme\Plugin\Checkout;


class LayoutProcessor
{
    protected $checkoutDataHelper;

    public function __construct(\Magento\Checkout\Helper\Data $checkoutDataHelper)
    {
        $this->checkoutDataHelper = $checkoutDataHelper;
    }

    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
        $jsLayout = $this->getShippingFormFields($jsLayout);
        $jsLayout = $this->getBillingFormFields($jsLayout);
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

        $paymentLayout = $jsLayout['components']['checkout']['children']['steps']['children']
                                    ['billing-step']['children']['payment']['children'];

        // if billing address should be displayed on Payment method or page
        if ($this->checkoutDataHelper->isDisplayBillingOnPaymentMethodAvailable()) {
            $componentNode = 'payments-list';
        } else {
            $componentNode = 'afterMethods';
        }

        if(isset($paymentLayout[$componentNode])) {

            $paymentForms = $paymentLayout[$componentNode]['children'];

            foreach ($paymentForms as $paymentMethodForm => $paymentMethodValue) {

                $paymentMethodCode = str_replace('-form', '', $paymentMethodForm);

                if (!isset($paymentLayout[$componentNode]['children'][$paymentMethodCode . '-form'])) {
                    continue;
                }

                $billingFields = $paymentLayout[$componentNode]['children'][$paymentMethodCode . '-form']['children']['form-fields']['children'];

                $billingPostcodeFields = $this->getFields('billingAddressshared' . '.custom_attributes', 'billing');
                if(isset($billingFields['company'])) {
                    $billingFields['company']['visible'] = false; // Hide 'company' field in billing address
                }

                $billingFields['telephone']['validation']['validate-digits'] = true;

                $billingFields = array_replace_recursive($billingFields, $billingPostcodeFields);

                $jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']
                [$componentNode]['children'][$paymentMethodCode . '-form']['children']['form-fields']['children'] = $billingFields;
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
                            'additionalClasses' => 'bank-name-field'
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
                            'additionalClasses' => 'bank-account-field'
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