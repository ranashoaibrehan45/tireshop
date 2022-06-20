let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .styles([
         'public/css/style.css',
      ], 'public/css/all.css')
   .scripts([
		    	'public/js/api_client.js',
		    ], 
		    'public/js/all.js');*/


mix.js('resources/assets/js/app.js', 'public/admin/js/')
   .sass('resources/assets/sass/app.scss', 'public/admin/css')
   .styles([
   		'public/admin/theme/vendor/bootstrap/css/bootstrap.min.css',
   		'public/admin/theme/vendor/metisMenu/metisMenu.min.css',
   		'public/admin/theme/dist/css/sb-admin-2.css',
   		'public/admin/theme/vendor/morrisjs/morris.css',
   		'public/admin/theme/vendor/font-awesome/css/font-awesome.min.css',
   	], 'public/admin/css/all.css')

   .scripts([
   		'public/admin/theme/vendor/jquery/jquery.min.js',
   		'public/admin/theme/vendor/bootstrap/js/bootstrap.min.js',
         'public/admin/theme/vendor/metisMenu/metisMenu.min.js',
   		'public/admin/theme/vendor/raphael/raphael.min.js',
   		//'public/admin/theme/vendor/morrisjs/morris.min.js',
   		//'public/admin/theme/data/morris-data.js',
   		'public/admin/theme/dist/js/sb-admin-2.js'
	], 'public/admin/js/all.js');
