// webpack.mix.js
const mix = require("laravel-mix");

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: [
                            [
                                "@babel/preset-env",
                                {
                                    modules: false,
                                },
                            ],
                        ],
                    },
                },
            },
        ],
    },
});

// JavaScript-Dateien kompilieren
mix.js("resources/js/app.js", "public/js")
    .js("resources/js/pages/logging_page.js", "public/js") // Hinzugefügtes `mix.` vor dieser Zeile
    .sourceMaps();

// SCSS-Dateien kompilieren
mix.sass("resources/scss/styles.scss", "public/css")
    .sass("resources/scss/pages/login.scss", "public/css")
    .sass("resources/scss/pages/logging_page.scss", "public/css");

// Kopiere die CSS-Datei
mix.copy("resources/css/welcome.css", "public/css/welcome.css");

// Entwicklungskonfiguration
if (!mix.inProduction()) {
    mix.sourceMaps();
    mix.browserSync({
        proxy: "127.0.0.1:8000",
        files: [
            "resources/views/**/*.blade.php",
            "resources/js/**/*.js",
            "resources/scss/**/*.scss",
        ],
        open: "external",
        host: "127.0.0.1",
        port: 8000,
        notify: true,
        online: true,
        ui: {
            port: 3002,
        },
    });

    setTimeout(() => {
        console.log("Waiting for files to update...");
    }, 1000);
}

// Produktionskonfiguration
if (mix.inProduction()) {
    mix.version();
}

// Kopiere zusätzliche Ressourcen
mix.copy("resources/fonts", "public/fonts").copy(
    "resources/images",
    "public/images"
);
