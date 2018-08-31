(() => {
    'use strict';

    angular
        .module('Ekspedisi.auth', [
            'ui.router',
            'ui.bootstrap',
            'ngStorage',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('login', {
                url: '/login',
                templateUrl: '/login',
                controller: 'LoginController as loginController',
            })
    });
})();
