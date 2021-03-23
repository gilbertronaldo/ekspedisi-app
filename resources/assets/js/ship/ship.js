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
            .state('admin.ship-add', {
                url: '/ship/add',
                templateUrl: '/ship/add',
                controller: 'AddShipController as addShipController',
            })
            .state('admin.ship-edit', {
                url: '/ship/edit/:id',
                templateUrl: '/ship/edit',
                controller: 'EditShipController as editShipController',
            })
            .state('admin.ship-departure', {
                url: '/ship/departure',
                templateUrl: '/ship/departure',
                controller: 'DepartureShipController as departureShipController',
            })
    });
})();
