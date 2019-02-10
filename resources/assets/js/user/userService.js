(() => {
    'use strict';

    angular.module('Ekspedisi.user').factory('UserService', UserService);

    UserService.$inject = ['$http', '$q'];

    function UserService($http, $q) {
        return {
            all: all,
            get: get,
            roles: roles,
            save: save,
            saveRoles: saveRoles,
            destroy: destroy
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

        function roles(id) {
            return $http.get(`/api/user/${id}/roles`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function saveRoles(id, data) {
            return $http.post(`/api/user/${id}/roles`, data)
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

        function destroy(id) {
            return $http.delete(`/api/user/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
