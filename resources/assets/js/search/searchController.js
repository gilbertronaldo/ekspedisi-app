;(() => {
    'use strict';

    angular
        .module('Ekspedisi.search')
        .controller('SearchController', SearchController);

    SearchController.$inject = [
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

    function SearchController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, ShipService, $rootScope, $timeout) {
        let vm = this;

        console.log(vm)
    }
})();
