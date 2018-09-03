(() => {
    'use strict';

    angular.module('Ekspedisi.master').factory('MasterService', MasterService);

    MasterService.$inject = ['$http', '$q'];

    function MasterService($http, $q) {
        return {
            cityList: cityList,
            countryList: countryList
        };

        function cityList() {
            return $http.get(`/api/master/city`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function countryList() {
            return $http.get(`/api/master/country`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
