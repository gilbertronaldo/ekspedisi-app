/**
 * @author Gilbert Ronaldo
 */
(function () {
    'use strict';

    angular.module('Ekspedisi.recipient').controller('EditRecipientController', EditRecipientController);

    EditRecipientController.$inject = [
        '$scope',
        '$state',
        '$stateParams',
        '$q',
        '$http',
        'RecipientService',
        'swangular',
        'MasterService'
    ];

    function EditRecipientController(
        $scope,
        $state,
        $stateParams,
        $q,
        $http,
        RecipientService,
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
            getRecipient();
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

            if (ctrl.input.email) {
                if (!validateEmail(ctrl.input.email)) {
                    swangular.alert("Format Email Salah");
                    return;
                }
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
                    $uiPopup.error('An Application Error Has Occurred');
                });
        }

        function getRecipient() {
            RecipientService.get($stateParams.id)
                .then(res => {
                    ctrl.input = res.data
                })
                .catch(err => {
                    swangular.alert("Error");
                })
        }

        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

    }
})();
