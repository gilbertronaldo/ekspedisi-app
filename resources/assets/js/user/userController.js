;(() => {
    'use strict';

    angular
        .module('Ekspedisi.user')
        .controller('UserController', UserController);

    UserController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'ShipService',
        '$rootScope',
        '$timeout'
    ];

    function UserController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        ShipService,
        $rootScope,
        $timeout) {
        let vm = this;

       console.log(vm);
    }
})();
