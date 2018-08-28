;(() => {
    'use strict'

    angular
        .module('Ekspedisi.login')
        .controller('LoginController', LoginController);

    LoginController.$inject = [
        '$localStorage',
        '$location',
        '$state'
    ];

    function LoginController(
        $localStorage,
        $location,
        $state
    ) {
        console.log(this)
        let ctrl = this;

        ctrl.doLogin = () => {
            console.log('login...')
            $localStorage.currentUser = {
                token: '1234'
            }
            $state.go('admin.home');
        }
    }
})();
