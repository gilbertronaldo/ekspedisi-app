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
            .state('admin.role-edit', {
                url: '/role/edit/:id?',
                templateUrl: '/role/edit',
                controller: 'EditRoleController as editRoleController',
                params: {
                    id: {squash: true, value: null},
                }
            })
            .state('admin.role-task', {
                url: '/role/task/:id',
                templateUrl: '/role/task',
                controller: 'TaskRoleController as taskRoleController',
            })
    });
})();
