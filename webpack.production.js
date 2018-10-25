const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: "production",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',
        ]
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, "css-loader"]
            }
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../css/app.css",
            chunkFilename: "[id].css"
        })
    ],
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                uglifyOptions: {
                    warning: "verbose",
                    ecma: 5,
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
