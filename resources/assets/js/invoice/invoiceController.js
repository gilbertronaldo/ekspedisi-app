;(() => {
    'use strict';

    angular
        .module('Ekspedisi.invoice')
        .controller('InvoiceController', InvoiceController);

    InvoiceController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'SenderService',
        'InvoiceService',
        '$rootScope',
        '$timeout'
    ];

    function InvoiceController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        SenderService,
        InvoiceService,
        $rootScope,
        $timeout
    ) {
        let vm = this;

        vm.can = {
            delete: $rootScope.authCan('INVOICE_DELETE'),
            printInvoice: $rootScope.authCan('INVOICE_PRINT_INVOICE'),
            printKwitansi: $rootScope.authCan('INVOICE_PRINT_KWITANSI')
        };

        $scope.dtInstance = {};
        $scope.dtInstanceCallback = function (instance) {
            $scope.dtInstance = instance;
        };

        vm.dtInstance = {};
        vm.dtInstanceCallback = (dtInstance) => {
            vm.dtInstance = dtInstance;
            console.log(vm.dtInstance);
            dtInstance.DataTable.on('draw.dt', () => {
                let elements = angular.element("#" + dtInstance.id + " .ng-scope");
                angular.forEach(elements, (element) => {
                    $compile(element)($scope)
                })
            });
        }
        ;
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/invoice',
                type: 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
                },
                dataSrc: json => {
                    vm.bapbList = json.data;
                    return vm.bapbList;
                }
            })
            .withOption('order', [4, 'desc'])
            .withOption('lengthMenu', [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, 'All']])
            .withDataProp('data')
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption('createdRow', createdRow)
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });
        vm.dtColumns = [
            DTColumnBuilder.newColumn('invoice_no').withTitle('No Invoice'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
            DTColumnBuilder.newColumn('bapb_no').withTitle('Bapb'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('No. Voyage'),
            DTColumnBuilder.newColumn('payment_date').withTitle('Payment date'),
            DTColumnBuilder.newColumn('creator').withTitle('Creator'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<div ng-controller="InvoiceController"><button class="btn btn-danger btn-xs" ng-click="deleteInvoice(' + data.invoice_id + ')" one-time-if="(' + vm.can.delete + ')">' +
                '   DELETE' +
                '</button>&nbsp;' +
                '<button class="btn btn-success btn-xs" ng-click="printInvoice(' + data.invoice_id + ')" one-time-if="(' + vm.can.printInvoice + ')">' +
                '   PRINT INVOICE' +
                '</button>&nbsp;' +
                '<button class="btn btn-success btn-xs" ng-click="printKwitansi(' + data.invoice_id + ')" one-time-if="(' + vm.can.printKwitansi + ')">' +
                '   PRINT KWITANSI' +
                '</button></div>';
        }

        $scope.printInvoice = id => {
            let pajak = 'perusahaan';
            let pph = false;
            swangular.confirm('Pajak?', {
                showCancelButton: true,
                confirmButtonText: 'Pribadi',
                cancelButtonText: 'Perusahaan',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#3085d6',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            }).then((res1) => {

                if (res1.value) {
                    pajak = 'pribadi';
                }

                swangular.confirm('Invoice dengan PPH?', {
                    showCancelButton: true,
                    confirmButtonText: 'Pakai PPH',
                    cancelButtonText: 'NonPPH',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false
                }).then((res2) => {
                    if (res2.value) {
                        pph = true;
                    }

                    const url = `http://${window.location.hostname}/api/invoice/generate/${id}?pajak=${pajak}&pph=${pph}&token=${$localStorage.currentUser.access_token}`;
                    const win = window.open(url, '_blank');
                    win.focus();
                });
            });
        };

        $scope.printKwitansi = id => {
            const win = window.open(`http://${window.location.hostname}/api/invoice/kwitansi/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

        $scope.deleteInvoice = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus invoice ini', {
                showCancelButton: true,
                preConfirm: () => {
                    InvoiceService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Invoice");
                            console.log(vm, $scope.dtInstance);
                            $state.reload();
                        })
                        .catch(err => {
                            console.log(err);
                            swangular.alert("Error");
                        })
                },
            })
        }
    }
})();
