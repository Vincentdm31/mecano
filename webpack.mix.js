const mix = require("laravel-mix");

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

mix
.js("resources/js/app.js", "public/js")
.js("resources/js/qrCodeScanner.js", "public/js")
    .sass("resources/scss/app.scss","public/css")
    .sass("resources/scss/home.scss","public/css")
    .sass("resources/scss/intervention.scss","public/css")
    .sass("resources/scss/qrcode.scss","public/css");

mix.inProduction() ? mix.version() : "";
