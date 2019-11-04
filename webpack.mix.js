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
        './src/**/*.php',
        './resources/**/*'
    ],
    globs: [
        path.join(__dirname, 'resources/js/vendor/**/*.js'),
        path.join(__dirname, 'node_modules/codemirror/**/*.js'),
        path.join(__dirname, 'node_modules/highlight.js/**/*.js'),
    ],
    whitelistPatterns: [
        /hljs/,
        /page/,
        /iframe/,
        /CodeMirror/,
        /CodeMirror-/,
        /editor/,
        /cm/,
        /easymde/,
        /th/,
        /td/,
        /footnote/,
        /hr/,
        // classnames in the service provider
        /p-2/,
        /flex/,
        /items-center/
    ]
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
