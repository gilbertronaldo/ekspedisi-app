const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    mode: "development",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',

        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin()
        ]
    }
};
