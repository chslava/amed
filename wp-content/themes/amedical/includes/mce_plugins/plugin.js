(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('galleryleft', {
                title : 'Gallery Left',
                cmd : 'galleryleft',
                image : url + '/galleryleft.png'
            });

            ed.addButton('galleryright', {
                title : 'Gallery Right',
                cmd : 'galleryright',
                image : url + '/galleryright.png'
            });

            ed.addButton('verticalmiddle', {
                title : 'Vertical middle col 3',
                cmd : 'verticalmiddle',
                image : url + '/verticalmiddle.png'
            });

            ed.addCommand('galleryleft', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<div class="img-text img-text--left">' + selected_text + '</div>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addCommand('galleryright', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<div class="img-text img-text--right">' + selected_text + '</div>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addCommand('verticalmiddle', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<div class="inline-height"></div><div class="inline-content-middle">' + selected_text + '</div>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Wptuts Buttons',
                author : 'Lee',
                authorurl : 'http://wp.tutsplus.com/author/leepham',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();