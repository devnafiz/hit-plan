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

mix.setPublicPath("public")
    .setResourceRoot("../") // Turns assets paths in css relative to css file
    .react()
    .sass("resources/sass/frontend/app.scss", "css/frontend.css")
    .sass("resources/sass/backend/app.scss", "css/backend.css")
    .sass("resources/sass/backend/extend.scss", "css/admin/extend.css")
    .js("resources/js/frontend/app.js", "js/frontend.js")
    .js("resources/js/backend/app.js", "js/backend.js")
    .extract([
        "alpinejs",
        "jquery",
        "bootstrap",
        "popper.js",
        "axios",
        "sweetalert2",
        "lodash",
    ])
    .sourceMaps();

if (mix.inProduction()) {
    mix.setPublicPath("public")
        .setResourceRoot("../")
        .combine(
            [
                "resources/css/icons/fontAwesome/css/all.css",
                "resources/css/icons/ionicons.min.css",
                "resources/css/icons/themify-icons.css",
                "resources/css/icons/linearicons.css",
                "resources/css/icons/flaticon.css",
                "resources/css/icons/simple-line-icons.css",
            ],
            "public/css/icons.css"
        )
        .combine(
            [
                "resources/css/admin-lte/css/adminlte.css",
            ],
            "public/css/admin/adminlte.css"
        )
        .combine(
            [
                "resources/js/backend/plugins/tinymce/jquery.tinymce.js",
                "resources/js/backend/plugins/tinymce/tinymce.js",
                "resources/js/backend/plugins/tinymce/editor-helper.js"
            ],
            "public/js/admin/editor.js"
        )
        .copyDirectory("resources/css/fonts", "public/fonts/")
        .copyDirectory(
            "resources/css/icons/fontawesome/webfonts",
            "public/webfonts/"
        )
        .version();
} else {
    // Uses inline source-maps on development
    mix.webpackConfig({
        devtool: "inline-source-map",
    });
}
