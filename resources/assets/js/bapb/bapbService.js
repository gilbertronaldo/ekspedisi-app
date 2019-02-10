(() => {
    'use strict';

    angular.module('Ekspedisi.bapb').factory('BapbService', BapbService);

    BapbService.$inject = ['$http', '$q'];

    function BapbService($http, $q) {
        return {
            get: get,
            no: no,
            store: store,
            delete: _delete,
            latest: latest,
            verify: verify,
            paymentList: paymentList,
            paymentSave: paymentSave
        };

        function get(id = '') {
            return $http.get(`/api/bapb/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function no(code) {
            return $http.get(`/api/bapb/no/${code}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function store(input) {
            return $http.post(`/api/bapb`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function _delete(id) {
            return $http.delete(`/api/bapb/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function verify(id) {
            return $http.post(`/api/bapb/verify/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function latest(code) {
            return $http.get(`/api/bapb/latest/${code}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function paymentList(param) {
            return $http.post(`/api/bapb/payment-list`, param)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function paymentSave(input) {
            return $http.post(`/api/bapb/payment-save`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
