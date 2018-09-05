(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.bapb-input', {
                url: '/bapb-input',
                templateUrl: '/bapb/input',
                controller: 'InputBapbController as inputBapbController',
            })
    });
})();
