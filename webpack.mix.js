const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
    require('autoprefixer'),
]);

mix.styles([
    'resources/assets/front/css/app.min.css',
], 'public/css/main.css');

mix.scripts([
    'resources/assets/front/js/fancybox.umd.js',
    'resources/assets/front/js/prism.js'
], 'public/js/main.js').sourceMaps();

mix.copyDirectory('resources/assets/front/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/front/images', 'public/images');
