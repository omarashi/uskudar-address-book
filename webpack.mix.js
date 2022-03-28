const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

const sassFiles = [
    'resources/css/app.scss',
];

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/alpine.js', 'public/js');
sassFiles.forEach(function (file) {
    mix.sass(file, 'public/css')
});
mix.options({
    postCss: [tailwindcss('./tailwind.config.js')],
}).version();

if (mix.inProduction()) {
    mix.version();
}
