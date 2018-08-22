const path = require('path');

module.exports = {
    mode: "development",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',
            './resources/assets/ts/vendor.ts',
            './resources/assets/ts/polyfills.ts',
            './resources/assets/ts/app/app.main.ts'
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    },
    resolve: {
        // Add `.ts` and `.tsx` as a resolvable extension.
        extensions: [".ts", ".tsx", ".js"]
    },
    module: {
        rules: [
            // all files with a `.ts` or `.tsx` extension will be handled by `ts-loader`
            {
                test: /\.tsx?$/,
                loader: "ts-loader",
                exclude: /node_modules/,
            }
        ]
    }
};