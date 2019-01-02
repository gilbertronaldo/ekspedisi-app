(() => {
    'use strict';

    angular.module('Ekspedisi.master').factory('MasterService', MasterService);

    MasterService.$inject = ['$http', '$q'];

    function MasterService($http, $q) {
        return {
            cityListMaster: cityListMaster,
            cityList: cityList,
            countryList: countryList
        };

        function cityListMaster() {
            return $q((resolve, reject) => {
                const cityList = [
                    {
                        city_id: 1,
                        city_code: 'JKT',
                        city_name: 'Jakarta'
                    },
                    {
                        city_id: 2,
                        city_code: 'BJM',
                        city_name: 'Banjarmasin'
                    },
                    {
                        city_id: 3,
                        city_code: 'SMD',
                        city_name: 'Samarinda'
                    },
                    {
                        city_id: 4,
                        city_code: 'BPP',
                        city_name: 'Balikpapan'
                    },
                    {
                        city_id: 5,
                        city_code: 'MKS',
                        city_name: 'Makassar'
                    }
                ];
                resolve({
                   data: cityList
                });
            });
        }

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
