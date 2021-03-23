(() => {
    'use strict';

    angular
        .module('Ekspedisi.pajak', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.pajak', {
                url: '/pajak',
                templateUrl: '/pajak',
                controller: 'PajakController as pajakController',
            })

    });
})();
