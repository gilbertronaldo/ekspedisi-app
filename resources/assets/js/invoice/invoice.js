(() => {
    'use strict';

    angular
        .module('Ekspedisi.invoice', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
            'ngSanitize',
            'ui.select',
            'sc.select'
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.invoice', {
                url: '/invoice',
                templateUrl: '/invoice',
                controller: 'InvoiceController as invoiceController',
            })
            .state('admin.invoice-input', {
                url: '/invoice-input/?:id',
                templateUrl: '/invoice/input',
                controller: 'InputInvoiceController as inputInvoiceController',
            })
    });
})();
