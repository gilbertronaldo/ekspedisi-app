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
        ctrl.loading = false;

        ctrl.doLogin = () => {
            ctrl.loading = true;
            AuthService.login(ctrl.input)
                .then(res => {
                    if (res.status === 'OK' && res.status_code === 200) {
                        $localStorage.currentUser = res.data;
                        $state.go('admin.home');
                    } else {
                        ctrl.loading = false;
                        swangular.alert("Email atau Password salah !");
                    }
                })
                .catch(err => {
                    ctrl.loading = false;
                    console.log(err);
                    swangular.alert("Error");
                })
        }
    }
})();
