/**
 * Grunt tasks configuration file.
 *
 * @link http://gruntjs.com/
 */

module.exports = function (grunt) {
    grunt.initConfig({

        /**
         * Package definitions.
         */
        pkg: grunt.file.readJSON("package.json"),

        /**
         * Banner to be printed to all processed files.
         */
        fileBanner: "/* <%= pkg.name %> v<%= pkg.version %> [ <%= grunt.template.today('yyyy-mm-dd') %> ]\n"+
            " *\n"+
            " * <%= pkg.description %>\n *\n"+
            " * Package    WordPress\n"+
            " * Subpackage MustUsePlugin|Redress\n"+
            " * Version    <%= pkg.version %>\n"+
            " * Author     <%= pkg.author.name %> <<%= pkg.author.email %>>\n"+
            " * Copyright  <%= pkg.copyright %>\n"+
            " * License    <%= pkg.license %>\n"+
            " * Link       <%= pkg.homepage %>\n"+
            " */\n",


        /* ---------------------------------------------------------------------- */


        /**
         * Script files validation. Do not include vendor files.
         *
         * @link https://github.com/gruntjs/grunt-contrib-jshint
         */
        jshint: {
            files: [
                "gruntfile.js",
                "scripts/*.js"
            ],

            options: {
                globals: {
                    window: false,
                    document: false,
                    $: true,
                    jQuery: false
                },
                validthis: true
            }
        },


        /**
         * Script files validation/minification.
         *
         * @link https://github.com/gruntjs/grunt-contrib-uglify
         */
        uglify: {
            options: {
                compress: {
                    drop_console: false
                },
                mangle: false,
                sourceMap: true,
                sourceMapIncludeSources: true
            },

            main: {
                options: {
                    sourceMapName: '../min/access.min.js.map'
                },
                files: {
                    "../min/access.min.js": [
                        "scripts/access.js"
                    ]
                }
            }
        },


        /**
         * Style files minification.
         *
         * @link https://github.com/gruntjs/grunt-contrib-jshint
         */
        cssmin: {
            options: {
                mediaMerging: true,
                roundingPrecision: -1,
                shorthandCompacting: true,
                sourceMap: true
            },

            target: {
                files: {
                    "../min/access.min.css": [
                        "styles/access.css"
                    ]
                }
            }
        },


        /**
         * Add custom banner to processed files.
         *  - postion: "bottom", "top", "replace"
         *
         * @link https://github.com/mattstyles/grunt-banner
         */
        usebanner: {
            dist: {
                options: {
                    position: "replace",
                    replace: true,
                    banner: "<%= fileBanner %>", /* Defined above ^ */
                    linebreak: true
                },
                files: {
                    src: [
                        "../min/*.min.css",
                        "../min/*.min.js"
                    ]
                }
            }
        },


        /**
         * Run tasks whenever watched files change.
         *
         * @link https://github.com/gruntjs/grunt-contrib-watch
         */
        watch: {
            options: {
                reload: true,
                spawn : false
            },

            grunt: {
                files: [ "gruntfile.js" ]
            },

            styles: {
                files: [
                    "styles/*.css"
                ],
                tasks: [ "cssmin", "usebanner" ]
            },

            scripts: {
                files: [
                    "scripts/*.js"
                ],
                tasks: [ "jshint", "uglify", "usebanner" ]
            }
        }
    });


    /**
     * Load NPM task modules.
     */
    grunt.loadNpmTasks("grunt-banner");
    grunt.loadNpmTasks("grunt-contrib-cssmin");
    grunt.loadNpmTasks("grunt-contrib-jshint");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-contrib-watch");


    /**
     * Register task(s).
     */
    grunt.registerTask("default", [ "watch" ]);
};

/* <> */
