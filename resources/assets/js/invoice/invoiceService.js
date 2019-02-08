(() => {
    'use strict';

    angular.module('Ekspedisi.invoice').factory('InvoiceService', InvoiceService);

    InvoiceService.$inject = ['$http', '$q'];

    function InvoiceService($http, $q) {
        return {
            no: no,
            store: store,
            delete: _delete,
            getBapbList: getBapbList
        };

        function getBapbList(param) {
            return $http.post(`/api/invoice/bapb-list`, param)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function no() {
            return $http.get(`/api/invoice/no`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function store(input) {
            return $http.post(`/api/invoice`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function _delete(id) {
            return $http.delete(`/api/invoice/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
