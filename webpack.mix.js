const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': __dirname + '/resources/js'
        },
    },
});

mix.js('resources/js/admin/app.js', 'public/js')
    .js('resources/js/frontend/vue-app.js', 'public/front/js')
    .sass('resources/sass/app.scss', 'public/css');


mix.browserSync({
    proxy: 'restaurant.test'
});
