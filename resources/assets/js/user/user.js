(() => {
    'use strict';

    angular
        .module('Ekspedisi.user', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.user', {
                url: '/user',
                templateUrl: '/user',
                controller: 'UserController as userController',
            })
    });
})();
