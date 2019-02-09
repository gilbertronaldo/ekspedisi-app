(() => {
    'use strict';

    angular.module('Ekspedisi.user').factory('UserService', UserService);

    UserService.$inject = ['$http', '$q'];

    function UserService($http, $q) {
        return {
            all: all
        };

        function all() {
            return $http.get(`/api/user`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
