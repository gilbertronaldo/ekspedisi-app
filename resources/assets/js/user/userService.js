(() => {
    'use strict';

    angular.module('Ekspedisi.user').factory('UserService', UserService);

    UserService.$inject = ['$http', '$q'];

    function UserService($http, $q) {
        return {};
    }
})();
