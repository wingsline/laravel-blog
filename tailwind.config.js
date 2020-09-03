module.exports = {
    purge: [
        "./src/**/*.php",
        "./resources/views/**/*.php",
        "./resources/js/**/*.js",
        "./node_modules/codemirror/**/*.js",
        "./node_modules/highlight.js/**/*.js",
    ],
    future: {
        removeDeprecatedGapUtilities: true,
    },
    theme: {
        container: {
            center: true
        },
        extend: {
            colors: {
                "white-50": "hsla(0, 0%, 100%, 0.5)",
                "white-90": "hsla(0, 0%, 100%, 0.97)"
            }
        }
    },
    variants: {},
    plugins: []
};
