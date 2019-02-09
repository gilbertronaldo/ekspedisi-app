(() => {
    'use strict';

    angular.module('Ekspedisi.user').factory('UserService', UserService);

    UserService.$inject = ['$http', '$q'];

    function UserService($http, $q) {
        return {
            all: all,
            get: get,
            save: save
        };

        function all() {
            return $http.get(`/api/user`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function get(id) {
            return $http.get(`/api/user/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function save(data) {
            return $http.post(`/api/user`, data)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
