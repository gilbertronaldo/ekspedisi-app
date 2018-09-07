/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.recipient').controller('AddRecipientController', AddRecipientController);

    AddRecipientController.$inject = [
        '$scope',
        '$state',
        '$q',
        '$http',
        'RecipientService',
        'swangular',
        'MasterService'
    ];

    function AddRecipientController(
        $scope,
        $state,
        $q,
        $http,
        RecipientService,
        swangular,
        MasterService
    ) {
        let ctrl = this;

        ctrl.input = {};

        init();

        function init() {
            getCityList();
        }

        ctrl.saveRecipient = () => {
            ctrl.is_saving = true;

            RecipientService.store(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {
                        throw {};
                    } else if (res.status === 'OK') {
                        $state.go('admin.recipient');
                        swangular.success("Data Penerima Berhasil Tersimpan");
                        ctrl.is_saving = false;
                    }
                })
                .catch(err => {
                    ctrl.is_saving = false;
                    console.log(err.data);
                    swangular.alert("Error");
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
