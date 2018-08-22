const path = require('path');

module.exports = {
    mode: "development",
    entry: './resources/assets/js/app.js',
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    }
};