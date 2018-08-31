/**
 * Created by Aldo on 22/09/2017
 */
(() => {
    'use strict';

    angular.module('Ekspedisi.auth').factory('AuthService', AuthService);

    AuthService.$inject = ['$http', '$q'];

    function AuthService($http, $q) {
        return {
            login: login
        };

        function login(input) {
            return $http.post(`/api/auth/login`, input)
                .then((res) => {
                    return $q.when(res.data.result);
                });
        }

    }
})();
