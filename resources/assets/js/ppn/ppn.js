(() => {
    'use strict';

    angular
        .module('Ekspedisi.ppn', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.ppn', {
                url: '/ppn',
                templateUrl: '/ppn',
                controller: 'PpnController as ppnController',
            })

    });
})();
