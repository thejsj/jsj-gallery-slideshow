module.exports = function (grunt) {

    'use strict';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                mangle: false,
                compress: false,
                beautify: true,
            },
            main: {
                files: {
                    'static/js/jsj-gallery-slideshow.min.js': [
                        // jQuery Easing
                        'static/js/libs/easing.min.js',
                        // Cycle 2
                        'static/js/libs/jquery.cycle2.js',
                        // Cycle 2 Transitions
                        'static/js/libs/transition/jquery.cycle2.carousel.js',
                        'static/js/libs/transition/jquery.cycle2.flip.js',
                        'static/js/libs/transition/jquery.cycle2.ie-fade.js',
                        'static/js/libs/transition/jquery.cycle2.scrollVert.js',
                        'static/js/libs/transition/jquery.cycle2.shuffle.js',
                        'static/js/libs/transition/jquery.cycle2.tile.js',
                        // Functional
                        'static/js/libs/functional/jquery.cycle2.caption2.js',
                        'static/js/libs/functional/jquery.cycle2.center.js',
                        'static/js/libs/functional/jquery.cycle2.swiper.js',
                        'static/js/libs/functional/jquery.cycle2.video.js',
                        // Cycle 2 Overwrites
                        'static/js/app/jquery.cycl2.overwrites.js',
                        // JSJ Gallery Slideshow Files
                        'static/js/app/functions.js',
                        'static/js/app/main.js',
                    ],
                }
            },
            default_theme: {
                files: {
                    'themes/default/js/main.js' : [
                        'themes/default/js/jsj-gallery-slideshow-default.js'
                    ]
                }
            },
            default_captions_theme: {
                files: {
                    'themes/default-captions/js/main.js' : [
                        'themes/default-captions/js/jsj-gallery-slideshow-default-caption.js'
                    ]
                }
            }
        },
        compass: {
            dist: {
                options: {
                    sassDir: './static/scss',
                    cssDir: './static/css',
                },
            },
            default_theme: {
                options: {
                    sassDir: './themes/default/scss',
                    cssDir: './themes/default/css',
                }
            },
            default_captions_theme: {
                options: {
                    sassDir: './themes/default-captions/scss',
                    cssDir: './themes/default-captions/css',
                }
            }
        },
        watch: {
            css: {
                files: ['./static/scss/*.scss', './themes/**/*.scss'],
                tasks: ['compass'],
            },
            js: {
                files: ['./static/js/**/*.js', './themes/**/jsj-*.js'],
                tasks: ['uglify'],
            }
        },
        shell: { // Doesn't Run in Watch
            generatePot: {
                options: {
                    stdout: true
                },
                command: [
                    'php ~/Sites/scripts/makepot/makepot.php wp-plugin .',
                    'mv jsj-gallery-slideshow.pot ./languages/jsj-gallery-slideshow.pot'
                ].join('&&')
            },
        },
        wp_readme_to_markdown: {
            your_target: {
                files: {
                    'README.md': 'readme.txt'
                },
            },
        },
        checkwpversion: {
            options: {
                readme: 'readme.txt',
                plugin: 'jsj-gallery-slideshow.php',
            },
            check: { //Check plug-in version and stable tag match
                version1: 'plugin',
                version2: 'readme',
                compare: '==',
            },
            check2: { //Check plug-in version and package.json match
                version1: 'plugin',
                version2: '<%= pkg.version %>',
                compare: '==',
            },
        },
        clean: {
            //Clean up build folder
            main: ['build/jsj-gallery-slideshow']
        },
        copy: {
            // Copy the plugin to a versioned release directory
            main: {
                src:  [
                    '**',
                    '!node_modules/**',
                    '!build/**',
                    '!.git/**',
                    '!gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!.gitmodules',
                    '!*~',
                    '!README.md',
                    '!config.rb',
                ],
                dest: 'build/jsj-gallery-slideshow/',
            }
        },
        wp_deploy: {
            deploy: {
                options: {
                    plugin_slug: 'jsj-gallery-slideshow',
                    svn_user: 'jorge.silva',
                    build_dir: 'build/jsj-gallery-slideshow/' //relative path to your build directory
                },
            }
        },
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.loadNpmTasks('grunt-checkwpversion');
    grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
    grunt.loadNpmTasks('grunt-wp-deploy');
    grunt.loadNpmTasks('grunt-shell');

    // Default task(s).
    grunt.registerTask('default', ['uglify', 'compass']);
    grunt.registerTask('build', ['compass', 'uglify', 'checkwpversion', 'shell:generatePot', 'wp_readme_to_markdown', 'clean', 'copy']);
    grunt.registerTask('deploy', [ 'wp_readme_to_markdown', 'clean', 'copy', 'wp_deploy' ]);


};