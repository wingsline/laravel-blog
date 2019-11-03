const mix = require('laravel-mix');
const autoprefixer = require("autoprefixer");
const cssmqpacker = require("css-mqpacker");
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
    cssmqpacker(),
    autoprefixer(),
    postcssDiscardComments({
        removeAll: true
    })
];

// whitelist these class names
mix.purgeCss({
    folders: [
        "resources"
    ],
    whitelistPatterns: [/hljs/, /page/, /iframe/, /CodeMirror/, /CodeMirror-/, /editor/, /cm/, /th/, /td/, /footnote/, /hr/]
});

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
    // .js('resources/js/app.js', 'public')
    // .sass('resources/sass/app.scss', 'public')
    // .sass('resources/sass/app-dark.scss', 'public')
    .version()
    // .copy('public', '../telescopetest/public/vendor/telescope')
    .webpackConfig({
        resolve: {
            symlinks: false,
            alias: {
                '@': path.resolve(__dirname, 'resources/js/'),
            },
        }
    });
