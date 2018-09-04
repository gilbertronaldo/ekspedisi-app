/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.sender').controller('EditSenderController', EditSenderController);

    EditSenderController.$inject = [
        '$scope',
        '$state',
        '$stateParams',
        '$q',
        '$http',
        'SenderService',
        'swangular',
        'MasterService'
    ];

    function EditSenderController(
        $scope,
        $state,
        $stateParams,
        $q,
        $http,
        SenderService,
        swangular,
        MasterService
    ) {
        let ctrl = this;

        ctrl.input = {};

        init();

        function init() {
            getCityList();
            getSender();
        }

        ctrl.saveSender = () => {
            ctrl.is_saving = true;

            SenderService.store(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {
                        throw {};
                    } else if (res.status === 'OK') {
                        $state.go('admin.sender');
                        swangular.success("Data Pengirim Berhasil Tersimpan");
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

        function getSender() {
            SenderService.get($stateParams.id)
                .then(res => {
                    ctrl.input = res.data
                })
                .catch(err => {
                    swangular.alert("Error");
                })
        }

    }
})();
