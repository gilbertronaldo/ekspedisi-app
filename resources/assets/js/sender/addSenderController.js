/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.sender').controller('AddSenderController', AddSenderController);

    AddSenderController.$inject = [
        '$scope',
        '$state',
        '$q',
        '$http',
        'SenderService',
        'swangular',
        'MasterService'
    ];

    function AddSenderController(
        $scope,
        $state,
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
        }

        ctrl.saveSender = () => {
            if (!ctrl.input.sender_code) {
                swangular.alert("Kode Pengirim wajib di isi");
                return;
            }

            if (!ctrl.input.sender_name) {
                swangular.alert("Nama Pengirim wajib di isi");
                return;
            }

            if (!ctrl.input.sender_phone) {
                swangular.alert("Nomor Handphone wajib di isi");
                return;
            }

            ctrl.is_saving = true;

            SenderService.store(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {
                        throw {};
                    } else if (res.status === 'OK') {
                        $state.go('admin.sender');
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
