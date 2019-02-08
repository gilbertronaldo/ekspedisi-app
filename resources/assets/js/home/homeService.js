(() => {
    'use strict';

    angular.module('Ekspedisi.home').factory('HomeService', HomeService);

    HomeService.$inject = ['$http', '$q'];

    function HomeService($http, $q) {
        return {
            header: header,
        };

        function header() {
            return $http.get(`/api/home/header`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
