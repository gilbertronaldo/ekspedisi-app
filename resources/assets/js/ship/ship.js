(() => {
    'use strict';

    angular
        .module('Ekspedisi.ship', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.ship', {
                url: '/ship',
                templateUrl: '/ship',
                controller: 'ShipController as shipController',
            })
    });
})();
