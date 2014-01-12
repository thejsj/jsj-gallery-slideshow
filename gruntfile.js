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
                }
        },
	});

	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-shell');

	// Default task(s).
	grunt.registerTask('default', ['uglify', 'compass','shell:generatePot']);

};