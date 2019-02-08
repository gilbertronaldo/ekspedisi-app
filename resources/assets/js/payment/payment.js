(() => {
    'use strict';

    angular
        .module('Ekspedisi.payment', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
            'ngSanitize',
            'ui.select',
            'sc.select'
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.payment', {
                url: '/payment',
                templateUrl: '/payment',
                controller: 'PaymentController as paymentController',
            })
    });
})();
