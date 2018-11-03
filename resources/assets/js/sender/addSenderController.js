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

        ctrl.minimumChargeCalculationList = [
            {
                calculation_id: 1,
                calculation_name: 'Meter Kubik'
            },
            {
                calculation_id: 2,
                calculation_name: 'Rp'
            },
            {
                calculation_id: 3,
                calculation_name: 'Kg'
            }
        ];

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

            if (!ctrl.input.sender_name_bapb) {
                swangular.alert("Nama Pengirim di BAPB wajib di isi");
                return;
            }

            if (!ctrl.input.sender_phone) {
                swangular.alert("Nomor Handphone wajib di isi");
                return;
            }

            if (!ctrl.input.sender_telephone) {
                swangular.alert("Nomor Telephone wajib di isi");
                return;
            }

            if (!ctrl.input.city_id) {
                swangular.alert("Kota Penerima wajib di isi");
                return;
            }

            if (!ctrl.input.sender_address) {
                swangular.alert("Alamat Penerima wajib di isi");
                return;
            }

            if (ctrl.input.email) {
                if (!validateEmail(ctrl.input.email)) {
                    swangular.alert("Format Email Salah");
                    return;
                }
            }

            ctrl.is_saving = true;

            SenderService.store(ctrl.input)
                .then(res => {
                    if (res.status === 'FAIL') {
                        swangular.alert(res.data.message);
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

        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

    }
})();
