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
        '$http',
        'RecipientService',
        'SenderService'
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
        $http,
        RecipientService,
        SenderService
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.detail = {};

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

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
                    ctrl.detail.shipList = result.data.shipList;
                    return result.data.shipList;
                });
        };
        ctrl.getShipDetail = () => {
            if (!ctrl.input.ship_id) {
                return;
            }
            ctrl.detail.ship = ctrl.detail.shipList.find(i => i.ship_id === ctrl.input.ship_id);
        }

        ctrl.recipientAsyncPageLimit = 20;
        ctrl.recipientTotalResults = 0;

        ctrl.searchRecipientList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return RecipientService.search({
                params: {
                    text: searchText,
                    limit: ctrl.recipientAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    ctrl.recipientTotalResults = result.data.total;
                    ctrl.detail.recipientList = result.data.recipientList;
                    return result.data.recipientList;
                });
        };
        ctrl.getRecipientDetail = () => {
            if (!ctrl.input.recipient_id) {
                return;
            }
            ctrl.detail.recipient = ctrl.detail.recipientList.find(i => i.recipient_id === ctrl.input.recipient_id);
        }
    }
})();
