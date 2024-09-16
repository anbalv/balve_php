window._ = require("lodash");
window.axios = require("axios");

// Optional: Bootstrap und andere Bibliotheken laden
try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    require("bootstrap");
} catch (e) {}
