(() => {
    'use strict';

    angular
        .module('Ekspedisi.tracing', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.tracing', {
                url: '/tracing',
                templateUrl: '/tracing',
                controller: 'TracingController as tracingController',
            })

    });
})();
