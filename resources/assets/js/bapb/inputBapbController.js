;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('InputBapbController', InputBapbController);

    InputBapbController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'ShipService',
        '$http'
    ];

    function InputBapbController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        ShipService,
        $http
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.detail = {};

        getShip();

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

        ctrl.people = [];
        ctrl.searchShipList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return ShipService.search({
                params: {
                    text: searchText,
                    limit: ctrl.shipAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    ctrl.shipTotalResults = result.data.total;
                    return result.data.shipList;
                });
        };

        ctrl.getShipDetail = function (searchText, page) {
            if (!searchText) {
                return [];
            }
        }

        function getShip() {
            ShipService.get(-99)
                .then(res => {
                    ctrl.shipList = res.data;
                    ctrl.detail.shipList = res.data;
                })
                .catch(err => {
                    swangular.alert("Error");
                })
        }

        ctrl.getShipDetail = () => {
            if (!ctrl.input.ship_id) {
                return;
            }
            ctrl.detail.ship = ctrl.detail.shipList.find(i => i.ship_id === ctrl.input.ship_id);
        }
    }
})();
