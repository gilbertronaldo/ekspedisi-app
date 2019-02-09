(() => {
    'use strict';

    angular.module('Ekspedisi.home').factory('HomeService', HomeService);

    HomeService.$inject = ['$http', '$q'];

    function HomeService($http, $q) {
        return {
            init: init,
            header: header,
        };


        function init() {
            return $http.get(`/api/my/init`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function header() {
            return $http.get(`/api/home/header`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
