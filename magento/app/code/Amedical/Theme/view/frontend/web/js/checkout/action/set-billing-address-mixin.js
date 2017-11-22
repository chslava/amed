define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction, messageContainer) {

            var billingAddress = quote.billingAddress();
console.log(quote);
            if(billingAddress != undefined) {

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }

                if (billingAddress.customAttributes != undefined) {
                    $.each(billingAddress.customAttributes, function (key, value) {

                        if($.isPlainObject(value)){
                            value = value['value'];
                        }

                        billingAddress['extension_attributes'][key] = value;
                    });
                }

                if(quote.custom_data !== undefined) {
                    $.each(quote.custom_data , function( key, value ) {

                        if($.isPlainObject(value)){
                            value = value['value'];
                        }

                        billingAddress['customAttributes'][key] = value;
                        billingAddress['extension_attributes'][key] = value;

                    });
                }

            }

            return originalAction(messageContainer);
        });
    };
});