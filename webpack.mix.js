const mix = require('laravel-mix');
const autoprefixer = require("autoprefixer");
const postcssDiscardComments = require("postcss-discard-comments");
const postCssImport = require("postcss-import");
const postInlineSvg = require("postcss-inline-svg");
const tailwindcss = require("tailwindcss");
require("laravel-mix-purgecss");
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

const postCssOptions = [
    postCssImport(),
    tailwindcss(),
    postInlineSvg(),
    autoprefixer(),
    postcssDiscardComments({
        removeAll: true
    })
];

mix.options({
    autoprefixer: false,
    processCssUrls: false,
    postCss: postCssOptions,
    terser: {
        terserOptions: {
            compress: {
                drop_console: true,
            },
        },
    },
})
    .setPublicPath('public')
    .copyDirectory("resources/fonts", "public/fonts")
    .postCss("resources/css/main.css", "public")
    .js("resources/js/app.js", "public")
    .version()
    .extract()
    .webpackConfig({
        resolve: {
            symlinks: false,
            alias: {
                '@': path.resolve(__dirname, 'resources/js/'),
            },
        }
    });
