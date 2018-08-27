(() => {
    'use strict';

    angular
        .module('Ekspedisi.login', [
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
