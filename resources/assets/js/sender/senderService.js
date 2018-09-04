(() => {
    'use strict';

    angular.module('Ekspedisi.sender').factory('SenderService', SenderService);

    SenderService.$inject = ['$http', '$q'];

    function SenderService($http, $q) {
        return {
            get: get,
            store: store,
            delete: _delete,
        };

        function get(id = '') {
            return $http.get(`/api/sender/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function store(input) {
            return $http.post(`/api/sender/`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function _delete(id) {
            return $http.delete(`/api/sender/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
