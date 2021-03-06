/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.ship').controller('EditShipController', EditShipController);

    EditShipController.$inject = [
        '$scope',
        '$state',
        '$stateParams',
        '$q',
        '$http',
        'ShipService',
        'swangular',
        'MasterService'
    ];

    function EditShipController(
        $scope,
        $state,
        $stateParams,
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
            getShip();
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

        function getShip() {
            ShipService.get($stateParams.id)
                .then(res => {
                    if (res.data.sailing_date) {
                        res.data.sailing_date = moment(res.data.sailing_date, "DD-MM-YYYY");
                    }
                    ctrl.input = res.data;
                })
                .catch(err => {
                    swangular.alert("Error");
                })
        }

        ctrl.openPeriodDatePicker = ($event, datePickerIndex) => {
            $event.preventDefault();
            $event.stopPropagation();

            ctrl.periodDatePickerOpened.forEach((item, idx) => {
                ctrl.periodDatePickerOpened[idx] = idx === datePickerIndex;
            });
        };

        ctrl.changeCity = () => {

        }

        function getCityList() {
            MasterService.cityListMaster()
                .then(res => {
                    ctrl.cityList = res.data;
                })
                .catch(err => {
                    console.log(err.data);
                    $uiPopup.error('An Application Error Has Occurred');
                });
        }

    }
})();
