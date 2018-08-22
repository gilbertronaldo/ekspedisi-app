const path = require('path');

module.exports = {
    mode: "production",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    }
};