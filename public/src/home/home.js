(() => {
    'use strict';

    angular
        .module('Ekspedisi.home', [
            'ui.router',
            'ui.bootstrap',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.home', {
                url: '/home',
                templateUrl: '/home/dashboard',
                controller: 'HomeController as homeController',
            })
    });
})();
