const path = require('path');

module.exports = {
    mode: "development",
    devtool: "inline-source-map",
    entry: {
        app: [
            './resources/assets/js/app.js',

            './resources/assets/js/main/app.js',
            './resources/assets/js/admin/admin.js',
            './resources/assets/js/admin/adminController.js',
            './resources/assets/js/home/home.js',
            './resources/assets/js/home/homeController.js',
            './resources/assets/js/auth/auth.js',
            './resources/assets/js/auth/authService.js',
            './resources/assets/js/auth/loginController.js',
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js'
    }
};
