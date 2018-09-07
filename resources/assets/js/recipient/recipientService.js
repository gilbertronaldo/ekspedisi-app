(() => {
    'use strict';

    angular.module('Ekspedisi.recipient').factory('RecipientService', RecipientService);

    RecipientService.$inject = ['$http', '$q'];

    function RecipientService($http, $q) {
        return {
            get: get,
            store: store,
            delete: _delete,
        };

        function get(id = '') {
            return $http.get(`/api/recipient/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function store(input) {
            return $http.post(`/api/recipient/`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function _delete(id) {
            return $http.delete(`/api/recipient/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
