(() => {
    'use strict';

    angular
        .module('Ekspedisi.recipient', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.recipient', {
                url: '/recipient',
                templateUrl: '/recipient',
                controller: 'RecipientController as recipientController',
            })
            .state('admin.recipient-add', {
                url: '/recipient/add',
                templateUrl: '/recipient/add',
                controller: 'AddRecipientController as addRecipientController',
            })
            .state('admin.recipient-edit', {
                url: '/recipient/edit/:id',
                templateUrl: '/recipient/edit',
                controller: 'EditRecipientController as editRecipientController',
            })
    });
})();
