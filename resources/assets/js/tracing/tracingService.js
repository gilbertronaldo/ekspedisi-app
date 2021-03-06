(() => {
    'use strict';

    angular.module('Ekspedisi.tracing').factory('TracingService', TracingService);

    TracingService.$inject = ['$http', '$q'];

    function TracingService($http, $q) {
        return {
            detail: detail,
            save: save,
            deleteTracing: deleteTracing,
        };

        function detail(param) {
            return $http.post(`/api/tracing`, param)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function save(param) {
            return $http.post(`/api/tracing/save`, param, {
                headers: {
                    "Content-Type": undefined,
                }
            })
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function deleteTracing(tracingId) {
            return $http.delete(`/api/tracing/${tracingId}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
