const path = require('path');

module.exports = {
    mode: "development",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',

            './public/src/main/app.js',
            './public/src/admin/admin.js',
            './public/src/admin/adminController.js',
            './public/src/home/home.js',
            './public/src/home/homeController.js',
            './public/src/auth/auth.js',
            './public/src/auth/authService.js',
            './public/src/auth/loginController.js',
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    }
};
