/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/*global define*/
define(
    [
        'uiComponent',
        'ko',
        'jquery',
        'Magento_Checkout/js/model/sidebar'
    ],
    function(Component, ko, $, sidebarModel) {
        'use strict';

        var checkoutConfig = window.checkoutConfig;

        return Component.extend({
            cmsBlockContent: checkoutConfig.cmsBlockContent,
            setModalElement: function(element) {
                sidebarModel.setPopup($(element));
            }
        });
    }
);
