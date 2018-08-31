;(() => {
    'use strict'

    angular
        .module('Ekspedisi.auth')
        .controller('LoginController', LoginController);

    LoginController.$inject = [
        '$localStorage',
        '$location',
        '$state',
        'AuthService',
        'swangular',
        '$http'
    ];

    function LoginController(
        $localStorage,
        $location,
        $state,
        AuthService,
        swangular,
        $http
    ) {
        console.log(this);
        let ctrl = this;
        ctrl.input = {};

        ctrl.doLogin = () => {
            AuthService.login(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL' && res.status_code === 401) {
                        swangular.alert("Email atau Password salah !");
                    } else if (res.status === 'OK' && res.status_code === 200) {
                        $localStorage.currentUser = res.data;
                        $state.go('admin.home');
                    } else {
                        swangular.alert("Error");
                    }
                })
                .catch(err => {
                    console.log(err)
                    swangular.alert("Error");
                })
        }
    }
})();
