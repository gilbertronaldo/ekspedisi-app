;(() => {
    'use strict'

    angular
        .module('Ekspedisi.auth')
        .controller('LoginController', LoginController);

    LoginController.$inject = [
        '$localStorage',
        '$location',
        '$state',
        'AuthService'
    ];

    function LoginController(
        $localStorage,
        $location,
        $state,
        AuthService
    ) {
        console.log(this);
        let ctrl = this;
        ctrl.input = {};

        ctrl.doLogin = () => {
            AuthService.login(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {

                    } else if (res.status === 'OK' && res.status_code === 200) {
                        $localStorage.currentUser = res.data;
                        $state.go('admin.home');
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
})();
