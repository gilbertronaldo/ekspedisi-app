;(() => {
    'use strict';

    angular
        .module('Ekspedisi.payment')
        .controller('PaymentController', PaymentController);

    PaymentController.$inject = [
        '$window',
        '$state',
        '$stateParams',
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
        'SenderService',
        'BapbService',
        'InvoiceService'
    ];

    function PaymentController(
        $window,
        $state,
        $stateParams,
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
        SenderService,
        BapbService,
        InvoiceService
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.codeList = [
            {code_id: 1, name: 'BJM - Banjarmasin'},
            {code_id: 2, name: 'SMD - Samarinda'},
            {code_id: 3, name: 'BPP - Balikpapan'},
            {code_id: 4, name: 'MKS - Makassar'},
            {code_id: 5, name: 'KJ - Retur'},
        ];
        ctrl.code = 1;
        ctrl.detail = {};

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

        function getShip() {
            ShipService.get(ctrl.input.ship_id)
                .then(res => {
                    ctrl.detail.ship = res.data;

                    if (!ctrl.id) {
                        const code = ctrl.codeList.find(code => code.name.substr(0, 3) == ctrl.detail.ship.city_to.city_code);
                        ctrl.code = code.code_id;
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }

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
                    ctrl.shipTotalResults = result.data.count;
                    ctrl.detail.shipList = result.data.shipList;
                    return result.data.shipList;
                });
        };
        ctrl.getShipDetail = () => {
            if (!ctrl.input.ship_id) {
                return;
            }
            ctrl.detail.ship = ship;
        };

    }
})();
