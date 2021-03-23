(() => {
    'use strict';

    angular.module('Ekspedisi.pajak').factory('PajakService', PajakService);

    PajakService.$inject = ['$http', '$q'];

    function PajakService($http, $q) {
        return {
            list: list,
            save: save,
        };

        function list(param) {
            return $http.get(`/api/pajak`, param)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function save(param) {
            return $http.put(`/api/pajak`, param)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
