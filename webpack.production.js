const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

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
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                uglifyOptions: {
                    warning: "verbose",
                    ecma: 8,
                    beautify: true,
                    compress: {
                        drop_console: true,
                        warnings: true
                    },
                    comments: true,
                    mangle: false,
                    toplevel: true,
                    keep_classnames: true,
                    keep_fnames: true
                }
            })
        ]
    }
};
