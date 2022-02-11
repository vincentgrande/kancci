const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/theme/js/jquery.min.js', 'public/js')
    .js('resources/theme/jquery-easing/jquery.easing.min.js', 'public/js')
    .js('resources/theme/bootstrap/js/bootstrap.bundle.min.js', 'public/js')
    .js('resources/theme/js/sb-admin-2.min.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/theme/sass/sb-admin-2.scss', 'public/css')
    .sass('resources/theme/fontawesome-free/css/all.min.scss', 'public/css');


