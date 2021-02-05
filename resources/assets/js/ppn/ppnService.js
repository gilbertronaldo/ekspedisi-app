(() => {
    'use strict';

    angular.module('Ekspedisi.ppn').factory('PpnService', PpnService);

    PpnService.$inject = ['$http', '$q'];

    function PpnService($http, $q) {
        return {
            get: get
        };

        function get(id = '') {
            return $http.get(`/api/ship/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
