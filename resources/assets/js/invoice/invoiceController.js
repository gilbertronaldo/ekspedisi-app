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
        'InvoiceService'
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
        InvoiceService
    ) {
        let vm = this;

        vm.dtInstance = {};
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
            .withOption('order', [0, 'desc'])
            .withOption('lengthMenu', [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, 'All']])
            .withDataProp('data')
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption('createdRow', createdRow)
        vm.dtColumns = [
            // DTColumnBuilder.newColumn('invoice_no').withTitle('No Invoice'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
            DTColumnBuilder.newColumn('bapb_no').withTitle('Bapb'),
            DTColumnBuilder.newColumn('no_ttb').withTitle('No. TTB'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<div><button class="btn btn-danger btn-xs" ng-click="vm.deleteInvoice(' + data.invoice_id + ')">' +
                '   DELETE' +
                '</button>&nbsp;' +
                '<button class="btn btn-success btn-xs" ng-click="vm.printInvoice(' + data.invoice_id + ')">' +
                '   PRINT INVOICE' +
                '</button>&nbsp;' +
                '<button class="btn btn-success btn-xs" ng-click="vm.printKwitansi(' + data.invoice_id + ')">' +
                '   PRINT KWITANSI' +
                '</button></div>';
        }

        vm.editInvoice = id => {
            console.log(id)
            $state.go('admin.bapb-input', {id: id});
        }

        vm.printInvoice = id => {
            const win = window.open(`http://${window.location.hostname}/api/invoice/generate/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

        vm.printKwitansi = id => {
            const win = window.open(`http://${window.location.hostname}/api/invoice/kwitansi/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

        vm.deleteInvoice = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus invoice ini', {
                showCancelButton: true,
                preConfirm: () => {
                    InvoiceService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Invoice");
                            vm.dtInstance.rerender();
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
