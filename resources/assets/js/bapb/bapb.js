(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
            'ngSanitize',
            'ui.select',
            'sc.select'
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.bapb', {
                url: '/bapb',
                templateUrl: '/bapb',
                controller: 'BapbController as bapbController',
            })
            .state('admin.bapb-input', {
                url: '/bapb-input',
                templateUrl: '/bapb/input',
                controller: 'InputBapbController as inputBapbController',
            })
    });
})();
