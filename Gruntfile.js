module.exports = function(grunt) {

	require('time-grunt')(grunt);
	
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	grunt.initConfig({

		watch: {
			options: {
				livereload: true,
				nospawn: true
			},
			html: {
				files: ['Gruntfile.js','*.html'],
			},
			js: {
				files: ['Gruntfile.js','assets/js/*'],
				tasks: ['js']
			},
			sass: {
				files: ['Gruntfile.js','assets/sass/*.sass'],
				tasks: ['css']
			}
		},

		sass: {
			css: {
				options: {
					style: 'nested',
					// lineNumbers: true
				},
				files: {
					'assets/css/style.css': 'assets/sass/style.sass'
				}
			}
		},


		jshint: {
			options: {
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			},
			js: ['Gruntfile.js', 'assets/js/custom.js']
		},


		// uglify: {
		// 	options: {},
		// 	js: {
		// 		src: 'src/js/main.js',
		// 		dest: 'assets/js/main.js'
		// 	}
		// },

		connect: {
			server: {
				options: {
					hostname: '127.0.0.1',
					port: 8080,
					base: '',
					livereload: true
				}
			}
		},


	});

	grunt.registerTask('js',['jshint']);
	grunt.registerTask('css',['sass']);

	grunt.registerTask('dev', ['connect', 'watch']);
	grunt.registerTask('build', ['js','css']);
	grunt.registerTask('default', ['build']);

};