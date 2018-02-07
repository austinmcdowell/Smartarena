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

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/massrunuploader.js', 'public/js')
   .js('resources/assets/js/masshumanuploader.js', 'public/js')
   .js('resources/assets/js/teamroping/new.js', 'public/js/teamroping')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/massrunuploader.scss', 'public/css')
   .sass('resources/assets/sass/profile.scss', 'public/css');
