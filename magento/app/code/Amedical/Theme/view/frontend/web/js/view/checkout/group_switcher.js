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

            if (quote['extension_attributes'] === undefined) {
                quote['extension_attributes'] = {};
            }

            quote['extension_attributes']['customerGroup'] = this.group();
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

            quote['extension_attributes']['customerGroup'] = this.group();
        },

        companyHasChanged: function (c, event) {
            this.company = event.target.value;
            quote['extension_attributes']['company'] = this.company;
        },

        positionOccupationHasChanged: function (c, event) {
            this.positionOccupation = event.target.value;
            quote['extension_attributes']['positionOccupation'] = this.positionOccupation;
        }
    });
});