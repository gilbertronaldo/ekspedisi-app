;(() => {
    'use strict';

    angular
        .module('Ekspedisi.role')
        .controller('RoleController', RoleController);

    RoleController.$inject = [
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

    function RoleController(
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
