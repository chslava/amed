var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'Amedical_Theme/js/checkout/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/select-billing-address': {
                'Amedical_Theme/js/checkout/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'Amedical_Theme/js/checkout/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Amedical_Theme/js/checkout/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Amedical_Theme/js/checkout/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Amedical_Theme/js/checkout/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/model/place-order': {
                'Amedical_Theme/js/checkout/action/place-order-mixin': true
            },
        }
    }
};