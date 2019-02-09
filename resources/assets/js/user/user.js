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
            .state('admin.user-edit', {
                url: '/user/edit/:id?',
                templateUrl: '/user/edit',
                controller: 'EditUserController as editUserController',
                params: {
                    id: { squash: true, value: null },
                }
            })
    });
})();
