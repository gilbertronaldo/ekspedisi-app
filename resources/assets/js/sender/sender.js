(() => {
    'use strict';

    angular
        .module('Ekspedisi.sender', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.sender', {
                url: '/sender',
                templateUrl: '/sender',
                controller: 'SenderController as senderController',
            })
            .state('admin.sender-add', {
                url: '/sender/add',
                templateUrl: '/sender/add',
                controller: 'AddSenderController as addSenderController',
            })
            .state('admin.sender-edit', {
                url: '/sender/edit/:id',
                templateUrl: '/sender/edit',
                controller: 'EditSenderController as editSenderController',
            })
    });
})();
