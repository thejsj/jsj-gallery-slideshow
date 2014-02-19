module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			my_target: {
				files: {
					'js/jsj-gallery-slideshow.js': [
						'js/libs/easing.min.js', 
						'js/libs/jquery.cycle.js', 
						'js/libs/browser.min.js', 
						'js/app/functions.js', 
						'js/app/main.js', 
					],
				}
			}
		},
		compass: {
			dist: {
				options: {
					sassDir: 'scss',
					cssDir: 'css',
				}
			}
		},
		watch: {
			css: {
				files: ['**/*.scss','**/*.js'],
				tasks: ['uglify', 'compass'],
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
					'readme.md': 'readme.txt'
				},
			},
		},
		checkwpversion: {
	        options:{
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
	grunt.registerTask('build', ['compass' ,'uglify', 'checkwpversion', 'shell:generatePot','wp_readme_to_markdown', 'clean', 'copy']);
	grunt.registerTask( 'deploy', [ 'wp_readme_to_markdown', 'clean', 'copy', 'wp_deploy' ] );


};