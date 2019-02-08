(() => {
    'use strict';

    angular.module('Ekspedisi.payment').factory('PaymentService', PaymentService);

    PaymentService.$inject = ['$http', '$q'];

    function PaymentService($http, $q) {
        return {
        };


    }
})();
