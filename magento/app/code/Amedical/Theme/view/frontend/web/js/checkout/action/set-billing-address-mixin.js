define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction) {

            var billingAddress = quote.billingAddress();

            if (billingAddress['extension_attributes'] === undefined) {
                billingAddress['extension_attributes'] = {};
            }

            billingAddress['extension_attributes']['bank_name'] = billingAddress.customAttributes['bank_name'];
            billingAddress['extension_attributes']['bank_account'] = billingAddress.customAttributes['bank_account'];

            return originalAction();
        });
    };
});