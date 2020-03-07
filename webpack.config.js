var Encore = require('@symfony/webpack-encore');
var webpack=require('webpack');
Encore
// the project directory where compiled assets will be stored
    //.setOutputPath('public/bundles/adminlte/')
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
   // .setPublicPath('/bundles/adminlte/')
    .setPublicPath('build/')
    .setManifestKeyPrefix('build/')
    // delete old files before creating them
    .cleanupOutputBeforeBuild()

    // add debug data in development
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // generate only two files: app.js and app.scss
    .addEntry('adminlte', './assets/adminlte-demo.js')
    /*.splitEntryChunks()
    .enableSingleRuntimeChunk()
    .enableIntegrityHashes()*/

    // enable sass/scss parser
    .enableSassLoader()
    //.autoProvidejQuery()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // for "legacy" applications that require $/jQuery as a global variable
    .autoProvidejQuery()

    // see https://symfony.com/doc/current/frontend/encore/bootstrap.html
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })

    .disableSingleRuntimeChunk()

    // add hash after file name
    .configureFilenames({
        js: '[name].js?[contenthash]',
        css: '[name].css?[contenthash]',
        images: 'images/[name].[ext]?[hash:8]',
        fonts: 'fonts/[name].[ext]?[hash:8]'
    })/**/
;
var config=Encore.getWebpackConfig();
config.module.rules[3].options.publicPath='./';
module.exports = config;
