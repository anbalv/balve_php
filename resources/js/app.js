require("./bootstrap");

// Lade popper.js und jquery aus node_modules
window.$ = window.jQuery = require("jquery");
require("popper.js");

// Optional: Wenn Bootstrap auch benötigt wird, kannst du es so einbinden
require("bootstrap");

// Importiere alle JS-Dateien aus dem pages-Verzeichnis außer logging_page.js
function importAll(r) {
    r.keys().forEach((key) => {
        if (!key.includes("logging_page.js")) {
            r(key);
        }
    });
}

importAll(require.context("./pages", true, /\.js$/));

// Importiere weitere JS-Dateien, die im pages-Verzeichnis liegen
// require("./bootstrap");
// console.log("Hello, world!");
