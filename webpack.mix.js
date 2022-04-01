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

mix.js('resources/js/app.js', 'public/js')
    .js("resources/js/alpine.js", "public/js")
    .sass("resources/scss/app.scss", "public/css")
    .options({
        postCss: [
            require("postcss-import"),
            require("tailwindcss"),
            require("postcss-nested"),
            require("postcss-preset-env")({ stage: 0 }),
        ],
    });

if (mix.inProduction()) {
    mix.version();
} else {
    mix.browserSync({
        proxy: "ideaal.test",
        files: ["**/*.html", "**/*.scss", "**/*./js"],
    });
}

/*
 |--------------------------------------------------------------------------
 | Statamic Control Panel
 |--------------------------------------------------------------------------
 |
 | Feel free to add your own JS or CSS to the Statamic Control Panel.
 | https://statamic.dev/extending/control-panel#adding-css-and-js-assets
 |
 */

// mix.js('resources/js/cp.js', 'public/vendor/app/js')
//    .postCss('resources/css/cp.css', 'public/vendor/app/css', [
//     require('postcss-import'),
//     require('tailwindcss/nesting'),
//     require('tailwindcss'),
// ])