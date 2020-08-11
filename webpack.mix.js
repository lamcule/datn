const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');
const backendThemeInfo = require('./themes/backend/theme.json');
const baseThemeInfo = require('./themes/base/theme.json');
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


mix.js('./themes/backend/resources/js/vueinit.js', 'themes/backend/js/app.js')
    .copy('./themes/backend/resources/js/library/jquery.min.js', './themes/backend/assets/js/jquery.min.js')
    .sass('./themes/backend/resources/scss/backend.scss', '../themes/backend/assets/css/backend.css')
    .styles(['./themes/backend/resources/css/custom.css', './themes/backend/assets/css/backend.css'], './themes/backend/assets/css/app.css');
    // mix.copyDirectory('./themes/backend/resources/images', './themes/backend/assets/images');
    // mix.copyDirectory('node_modules/admin-lte', './themes/backend/assets/vendor/admin-lte');
    // mix.copyDirectory('./themes/backend/resources/vendor/font-awesome', './themes/backend/assets/vendor/font-awesome');
    // mix.copyDirectory('./themes/backend/resources/vendor/bootstrap', './themes/backend/assets/vendor/bootstrap');
    // mix.copyDirectory('node_modules/element-ui/lib/theme-chalk/fonts', './public/fonts/vendor/element-ui/lib/theme-chalk');
    // mix.copyDirectory('./themes/backend/resources/js/library/tinymce4.7.5', './themes/backend/assets/vendor/tinymce');
    // mix.copyDirectory('./themes/backend/resources/js/library/jquery-ui', './themes/backend/assets/vendor/jquery-ui');

mix.js('./themes/base/resources/js/app.js', 'public/themes/base/js/app.js')
   .sass('./themes/base/resources/sass/app.scss', 'public/themes/base/assets/css')
   .styles(['./themes/base/resources/css/main.css'], 'public/themes/base/assets/css/main.css')
   .styles(['./themes/base/resources/css/vendors/owl.carousel.min.css'], 'public/themes/base/assets/css/vendors/owl.carousel.min.css')
   .styles(['./themes/base/resources/css/vendors/owl.theme.default.min.css'], 'public/themes/base/assets/css/vendors/owl.theme.default.min.css')
   .copy('./themes/base/resources/assets/images', 'public/themes/base/assets/images');

mix.webpackConfig({
    // resolve: {
    //     symlinks: false,
    //     extensions: ['.js', '.vue', '.json'],
    //   alias: {
    //     'vue$': 'vue/dist/vue.esm.js',
    //     '@': __dirname + '/themes/base/resources/js'
    //   }
    // },
    plugins: [
         new WebpackShellPlugin({onBuildExit:['php artisan theme:publish ' + backendThemeInfo.code]}),
         new WebpackShellPlugin({onBuildExit:['php artisan theme:publish ' + baseThemeInfo.code]}),
//  new WebpackShellPlugin({onBuildExit:['sudo ./dcp artisan theme:publish ' + backendThemeInfo.code]}),

    ],
});
