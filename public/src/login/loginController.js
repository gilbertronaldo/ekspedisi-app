;(() => {
    'use strict'

    angular
        .module('Ekspedisi.login')
        .controller('LoginController', LoginController);

    LoginController.$inject = [
        '$localStorage',
        '$location'
    ];

    function LoginController(
        $localStorage,
        $location
    ) {
        console.log(this)
        let ctrl = this;

        ctrl.doLogin = () => {
            console.log('login...')
            $localStorage.currentUser = {
                token: '1234'
            }
            $location.path('/admin/home');
        }
    }
})();
