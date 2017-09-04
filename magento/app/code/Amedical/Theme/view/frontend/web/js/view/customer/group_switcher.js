define([
    'ko',
    'uiComponent',
    'jquery'
], function (ko, Component, $) {
    'use strict';

    return Component.extend({
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
        }
    });
});