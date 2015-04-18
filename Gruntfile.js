module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		makepot: {
	        target: {
	            options: {
	                cwd: '',
	                domainPath: '/languages',
	                exclude: [
	                	'node_modules'
	                ],
	                mainFile: 'ilmenite-cookie-consent.php',
	                potFilename: 'ilcc.pot',
	                processPot: function( pot, options ) {
	                    pot.headers['report-msgid-bugs-to'] = 'https://github.com/bernskioldmedia/Ilmenite-Cookie-Consent/issues';
	                    pot.headers['language-team'] = 'Bernskiold Media <info@bernskioldmedia.com>';
	                    return pot;
	                },
	                type: 'wp-plugin',
	                updatePoFiles: true
	            }
	        }
	    },

		imagemin: {
         dist: {
            options: {
               optimizationLevel: 7,
               progressive: true
            },
            files: [{
               expand: true,
               cwd: 'assets/images/',
               src: '**/*',
               dest: 'assets/images/'
            }]
         }
     	},

		checktextdomain: {
		   options:{
		      text_domain: 'ilcc',
		      correct_domain: true, // Will correct missing/variable domains
		      keywords: [ // WordPress localisation functions
		            '__:1,2d',
		            '_e:1,2d',
		            '_x:1,2c,3d',
		            'esc_html__:1,2d',
		            'esc_html_e:1,2d',
		            'esc_html_x:1,2c,3d',
		            'esc_attr__:1,2d',
		            'esc_attr_e:1,2d',
		            'esc_attr_x:1,2c,3d',
		            '_ex:1,2c,3d',
		            '_n:1,2,4d',
		            '_nx:1,2,4c,5d',
		            '_n_noop:1,2,3d',
		            '_nx_noop:1,2,3c,4d'
		      ],
		   },
		   files: {
		       src:  [ '**/*.php', ], //All php files
		       expand: true,
		   },
		},

	});

	// Load Plugins
	grunt.loadNpmTasks( 'grunt-newer' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-imagemin' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	// Run!
	grunt.registerTask( 'test', [ 'checktextdomain' ] );
	grunt.registerTask( 'build', [ 'makemot', 'newer:imagemin' ] );

}