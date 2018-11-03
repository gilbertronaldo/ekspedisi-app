/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.ship').controller('AddShipController', AddShipController);

    AddShipController.$inject = [
        '$scope',
        '$state',
        '$q',
        '$http',
        'ShipService',
        'swangular',
        'MasterService'
    ];

    function AddShipController(
        $scope,
        $state,
        $q,
        $http,
        ShipService,
        swangular,
        MasterService
    ) {
        let ctrl = this;

        ctrl.input = {};
        ctrl.shipList = [];
        ctrl.periodDatePickerOpened = [false, false];

        init();

        function init() {
            getCityList();
        }

        ctrl.saveShip = () => {
            ctrl.is_saving = true;

            ShipService.store(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {
                        swangular.alert(res.data.message);
                    } else if (res.status === 'OK') {
                        $state.go('admin.ship');
                        swangular.success("Data Kapal Berhasil Tersimpan");
                        ctrl.is_saving = false;
                    }
                })
                .catch(err => {
                    ctrl.is_saving = false;
                    console.log(err.data);
                    swangular.alert("Error");
                });
        };

        ctrl.openPeriodDatePicker = ($event, datePickerIndex) => {
            $event.preventDefault();
            $event.stopPropagation();

            ctrl.periodDatePickerOpened.forEach((item, idx) => {
                ctrl.periodDatePickerOpened[idx] = idx === datePickerIndex;
            });
        };

        ctrl.changeCity = () => {
            console.log(ctrl.input);
        }

        function getCityList() {
            MasterService.cityList()
                .then(res => {
                    ctrl.cityList = res.data;
                    console.log(res)
                })
                .catch(err => {
                    console.log(err.data);
                    $uiPopup.error('An Application Error Has Occurred');
                });
        }

    }
})();
