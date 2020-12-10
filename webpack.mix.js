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

if (mix.inProduction()) {
    mix.version();
    mix.disableNotifications();
}


mix.copyDirectory('resources/img', 'public/img');

mix.js('resources/js/app.js', 'public/js')
    .extract(['jquery', 'vue', 'vuex'])
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/ckeditor.js', 'public/js');
mix.js('resources/js/select2.js', 'public/js');
