(() => {
    'use strict';

    angular.module('Ekspedisi.ship').factory('ShipService', ShipService);

    ShipService.$inject = ['$http', '$q'];

    function ShipService($http, $q) {
        return {
            get: get,
            store: store
        };

        function get() {
            return $http.get(`/api/ship/`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function store(input) {
            return $http.post(`/api/ship/`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
