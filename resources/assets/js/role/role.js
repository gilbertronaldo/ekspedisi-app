(() => {
    'use strict';

    angular
        .module('Ekspedisi.role', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.role', {
                url: '/role',
                templateUrl: '/role',
                controller: 'RoleController as roleController',
            })
    });
})();
