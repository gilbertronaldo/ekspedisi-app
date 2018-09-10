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

            if (!ctrl.input.recipient_code) {
                swangular.alert("Kode Penerima wajib di isi");
                return;
            }

            if (!ctrl.input.recipient_name) {
                swangular.alert("Nama Penerima wajib di isi");
                return;
            }

            if (!ctrl.input.recipient_phone) {
                swangular.alert("Nomor Handphone wajib di isi");
                return;
            }

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
                });
        }

    }
})();
