(() => {
    'use strict';

    angular.module('Ekspedisi.role').factory('RoleService', RoleService);

    RoleService.$inject = ['$http', '$q'];

    function RoleService($http, $q) {
        return {
            all: all,
            get: get,
            save: save,
            destroy: destroy,
            tasks: tasks,
            saveTasks: saveTasks
        };

        function all() {
            return $http.get(`/api/role`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function get(id) {
            return $http.get(`/api/role/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function save(data) {
            return $http.post(`/api/role`, data)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function destroy(id) {
            return $http.delete(`/api/role/${id}`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

        function tasks(id) {
            return $http.get(`/api/role/${id}/tasks`)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
        function saveTasks(id, tasks) {
            return $http.post(`/api/role/${id}/tasks`, tasks)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }
    }
})();
