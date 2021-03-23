;(() => {
        'use strict';

        angular
            .module('Ekspedisi.pajak')
            .controller('PajakController', PajakController);

        PajakController.$inject = [
            '$state',
            '$scope',
            'swangular',
            '$q',
            'DTOptionsBuilder',
            'DTColumnBuilder',
            '$localStorage',
            '$compile',
            'ShipService',
            '$rootScope',
            '$timeout',
            '$http',
            'PajakService',
            'RecipientService',
            '$window'
        ];

        function PajakController(
            $state,
            $scope,
            swangular,
            $q,
            DTOptionsBuilder,
            DTColumnBuilder,
            $localStorage,
            $compile,
            ShipService,
            $rootScope,
            $timeout,
            $http,
            PajakService,
            RecipientService,
            $window
        ) {

            let ctrl = this;
            ctrl.input = {
                date_start: moment(),
                date_end: null,
                ppn: null,
                pph_23: null,
            };

            ctrl.isSaving = false;
            ctrl.canEdit = true;

            ctrl.loading = [false, false];

            ctrl.pajakPpn = [];
            ctrl.pajakPph23 = [];

            getList();

            function getList() {
                ctrl.loading[0] = true;
                PajakService.list({})
                    .then(function (result) {
                        console.log(result.data);

                        ctrl.pajakPpn = result.data.ppn;
                        ctrl.pajakPph23 = result.data.pph_23;

                        ctrl.loading[0] = false;
                    })
                    .catch(err => {
                        console.log(err);
                        ctrl.loading[0] = false;
                        swangular.alert("Error Container List");
                    })
            }

            ctrl.onSubmit = () => {
                console.log(ctrl.input);

                if (
                    !ctrl.input.date_start ||
                    !ctrl.input.date_end ||
                    !ctrl.input.ppn ||
                    !ctrl.input.pph_23
                ) {
                    return;
                }

                swangular.confirm('Apakah anda yakin ingin menginput data ini', {
                    showCancelButton: true,
                    preConfirm: () => {

                        ctrl.isSaving = true;
                        const input = ctrl.input;

                        PajakService.save(input)
                            .then(function (result) {
                                ctrl.isSaving = false;
                                swangular.success("Berhasil Mengupdate Pajak");
                                getList();
                            })
                            .catch(err => {
                                ctrl.isSaving = false;
                                getList();
                                console.log(err);
                                swangular.alert("Error Container List");
                            })
                    }
                });
            }

        }
    }
)();
