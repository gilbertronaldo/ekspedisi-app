(() => {
    'use strict';

    angular
        .module('Ekspedisi.breakout', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
            'ngSanitize',
            'ui.select',
            'sc.select'
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.breakout', {
                url: '/breakout',
                templateUrl: '/breakout',
                controller: 'BreakoutController as breakoutController',
            })
    });
})();
