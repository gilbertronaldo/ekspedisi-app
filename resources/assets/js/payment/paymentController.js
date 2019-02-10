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
        'BapbService',
        '$http',
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
        BapbService,
        $http,
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.code = 1;
        ctrl.detail = {};

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

        ctrl.containerList = [];

        ctrl.loading = [
            false,
            false
        ];

        ctrl.inputMode = false;

        ctrl.checkedContainer = [];

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
            ctrl.detail.ship = ctrl.detail.shipList.find(i => i.ship_id === ctrl.input.ship_id);

            searchContainer();
        };

        function searchContainer() {
            ctrl.loading[0] = true;
            ctrl.checkedContainer = [];
            ctrl.containerList = [];
            ctrl.bapbList = [];
            ShipService.searchContainer({
                ship_id: ctrl.input.ship_id
            })
                .then(function (result) {
                    ctrl.loading[0] = false;
                    ctrl.containerList = result.data.containerList;
                })
                .catch(err => {
                    ctrl.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })
        }

        ctrl.onClickContainer = idx => {
            ctrl.containerList[idx].checked = !ctrl.containerList[idx].checked;

            console.log(ctrl.containerList[idx].checked);

            ctrl.checkedContainer = ctrl.containerList.filter(i => i.checked);

            if (ctrl.checkedContainer.length === 0) {
                return;
            }

            getBapbList();
        };

        ctrl.onCheckedContainer = () => {
            ctrl.checkedContainer = ctrl.containerList.filter(i => i.checked);

            if (ctrl.checkedContainer.length === 0) {
                return;
            }

            getBapbList();
        };

        function getBapbList() {
            ctrl.loading[1] = true;
            ctrl.bapbList = [];

            BapbService.paymentList({
                ship_id: ctrl.input.ship_id,
                containers: ctrl.checkedContainer.map(i => i.no_container)
            })
                .then(function (result) {
                    ctrl.loading[1] = false;
                    result.data.bapbList.forEach(i => {
                        if (i.payment_date) {
                            i.payment_date_ = i.payment_date;
                            i.payment_date = moment(i.payment_date, "DD-MM-YYYY");
                        }
                    })
                    ctrl.bapbList = result.data.bapbList;
                })
                .catch(err => {
                    ctrl.loading[1] = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })
        }

        ctrl.onInputPayment = idx => {

            if (ctrl.bapbList[idx].is_paid || ctrl.bapbList[idx].is_input) {
                return;
            }

            console.log('input');
            ctrl.bapbList.forEach(i => {
                i.is_input = false;
            });

            ctrl.bapbList[idx].is_input = true;

            ctrl.inputMode = ctrl.bapbList.filter(i => i.is_input).length > 0;
        };

        ctrl.onCancelPayment = () => {
            ctrl.bapbList.forEach(i => {
                i.is_input = false;
            });
        };

        ctrl.onSavePayment = idx => {
            ctrl.loading[1] = true;
            ctrl.bapbList.forEach(i => {
                i.is_input = false;
            });

            BapbService.paymentSave(ctrl.bapbList[idx])
                .then(function (result) {
                    ctrl.loading[1] = false;
                    getBapbList();
                })
                .catch(err => {
                    ctrl.loading[1] = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })
        }
    }
})();
