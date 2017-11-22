define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/quote'
], function ($, ko, Component, customer, quote) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amedical_Theme/checkout/group_switcher',
            isCustomerLoggedIn: customer.isLoggedIn,
            company: "",
            positionOccupation: ""
        },

        initialize: function () {
            //initialize parent Component
            this._super();
            this.group = ko.observable(this.defaultGroup);
        },

        switchGroup: function(c, event) {
            var element = event.target;
            var groupId = element.getAttribute('group');
            this.group(groupId);
            $(this.toggleSelector).removeClass('active');
            $(element).addClass('active');

            if(this.slideUpSelector && this.slideUpValue) {
                if (groupId == this.slideUpValue) {
                    $(this.slideUpSelector).slideUp(300);
                } else {
                    $(this.slideUpSelector).slideDown(300);
                }
            }

            this.assignCustomAttributes('customer_group_id', this.group());
        },

        companyHasChanged: function (c, event) {
            this.company = event.target.value;
            this.assignCustomAttributes('customer_company', this.company);
        },

        positionOccupationHasChanged: function (c, event) {
            this.positionOccupation = event.target.value;
            this.assignCustomAttributes('customer_position_occupation', this.positionOccupation);
        },

        assignCustomAttributes: function(key, value) {
            if(quote['custom_data'] === undefined) {
                quote['custom_data'] = {};
            }

            quote['custom_data'][key] = value;
        }
    });
});