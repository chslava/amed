define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (placeOrderModel) {
        return wrapper.wrap(placeOrderModel, function (originalModel, serviceUrl, payload, messageContainer) {

            if (payload['custom_attributes'] === undefined) {
                payload['custom_attributes'] = {};
            }

            if (Object.keys(quote['custom_attributes']).length) {
                $.each(quote['custom_attributes'] , function( key, value ) {

                    if($.isPlainObject(value)){
                        value = value['value'];
                    }

                    payload['custom_attributes'][key] = value;

                });
            }

            return originalModel(serviceUrl, payload, messageContainer);
        });
    };
});