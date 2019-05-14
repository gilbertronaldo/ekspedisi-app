(() => {
    'use strict';

    angular.module('Ekspedisi.search').factory('SearchService', SearchService);

    SearchService.$inject = ['$http', '$q'];

    function SearchService($http, $q) {
        return {

        };
    }
})();
