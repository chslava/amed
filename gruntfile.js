module.exports = function(grunt){
    // Running time statistic
    require('time-grunt')(grunt);
    // DRY Gruntfile.js
    grunt.loadNpmTasks('grunt-contrib-copy');
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    /**
     * Configuration
     */
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // DIRECTORIES
        cssDir: "./assets/css",
        jsDir: "./assets/js",


        /*
         * Create a dynamic build header.
         */
        banner: '/*!\n' +
        ' * <%= pkg.author.name %>\n' +
        ' * <%= pkg.author.url %>\n' +
        ' * <%= pkg.title %>\n' +
        ' * <%= grunt.template.today("dd-mm-yyyy-hh:MM:ss") %>\n' +
        ' * @author <%= pkg.author.name %>\n' +
        ' * @version <%= pkg.version %>\n' +
        ' */\n',


        /**
         * Bower Copy
         * https://www.npmjs.com/package/grunt-bowercopy
         * Scrupulously manage file locations for bower dependencies.
         */

        // bowercopy: {
        //     options: {
        //         srcPrefix: 'node_modules/react/dist'
        //     },
        //     scripts: {
        //         options: {
        //             destPrefix: '<%= jsDir %>/vendor'
        //         },
        //         files: {
        //             // TODO: Saspiest kopā priekš projekta
        //             'react.min.js': 'react.min.js',
        //         }
        //     },
        //     //later we need this
        //     // styles: {
        //     //     options: {
        //     //         destPrefix: '<%= sassDir %>/site/vendor'
        //     //     },
        //     //     files: {
        //     //         'archiefile.css': 'archiefile.css',
        //     //
        //     //
        //     //     }
        //     // }
        // }, //bowercopy end

        copy: {
            main:{
                nonull: true,
                src: 'node_modules/react/dist/react.min.js',
                dest: 'assets/js/vendor/react.min.js',
            },
        semanticcss: {
            nonull: true,
            src: 'ui/app/semantic.min.css',
            dest: 'assets/css/vendor/semantic.min.css',
        },
        semanticjs: {
            nonull: true,
            src: 'ui/app/semantic.min.js',
            dest: 'assets/js/vendor/semantic.min.js',
        },

            fulfillijs: {
                nonull: true,
                src: 'ui/app/fulfilli.js',
                dest: 'assets/js/fulfilli.js',
            },
            // themefiles:{
            //     files: [
            //         // includes files within path
            //         {expand: true, src: 'ui/app/themes/fulfilli/assets/**', dest: 'themes/fulfilli/assets', filter: 'isFile'},
            //     ]
            // }





        
},

    }); //initConfig end


    /**
     * Default task
     * Run `grunt` on the command line
     */

    grunt.registerTask('default', ['copy']);
    grunt.registerTask('copyfiles', ['copy']);

};
