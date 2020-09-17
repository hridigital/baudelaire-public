var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // neccessary so it can write manifest.json
    .setManifestKeyPrefix('build/')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()
;

if (Encore.isProduction()) {
    //Encore.setPublicPath('https://www.dhi.ac.uk/baudelaire/build')
    Encore.setPublicPath('https://www.baudelairesong.org/search/build')
} else {
    Encore.setPublicPath('http://localhost/build')
}

// export the final configuration
module.exports = Encore.getWebpackConfig();
