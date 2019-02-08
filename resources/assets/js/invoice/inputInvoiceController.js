;(() => {
    'use strict';

    angular
        .module('Ekspedisi.invoice')
        .controller('InputInvoiceController', InputInvoiceController);

    InputInvoiceController.$inject = [
        '$window',
        '$state',
        '$stateParams',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        '$http',
        'RecipientService',
        'InvoiceService'
    ];

    function InputInvoiceController(
        $window,
        $state,
        $stateParams,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        $http,
        RecipientService,
        InvoiceService
    ) {
        let vm = this;
        vm.input = {};
        vm.detail = {};
        vm.id = $stateParams.id;

        vm.bapbList = [];
        vm.newBapbList = [];

        function resetForm() {
            vm.input = {};
            vm.detail = {};
        }

        function init() {
            if (!vm.id) {
                noInvoice();
            } else {
            }
        }

        init();

        // vm.dtInstance = {};
        // vm.dtOptions = DTOptionsBuilder.newOptions()
        //     .withOption('ajax', {
        //         url: '/api/bapb?recipient_id=' + vm.input.recipient_id,
        //         type: 'GET',
        //         'beforeSend': function (request) {
        //             request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
        //         },
        //         data: function (search) {
        //             // fine tune what you need to send back here.
        //             search.recipient_id = vm.input.recipient;
        //             return search;
        //         },
        //         dataSrc: json => {
        //             vm.bapbList = json.data;
        //             return vm.bapbList;
        //         }
        //     })
        //     .withOption('order', [0, 'desc'])
        //     .withOption('lengthMenu', [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, 'All']])
        //     .withDataProp('data')
        //     .withOption('processing', true)
        //     .withOption('serverSide', true)
        //     .withPaginationType('full_numbers')
        //     .withOption('createdRow', createdRow)
        // vm.dtColumns = [
        //     DTColumnBuilder.newColumn('bapb_no').withTitle('No Bapb'),
        //     DTColumnBuilder.newColumn('no_voyage').withTitle('Deskripsi'),
        //     DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
        //     DTColumnBuilder.newColumn('no_container').withTitle('No Container'),
        //     DTColumnBuilder.newColumn('no_seal').withTitle('Seal'),
        //     DTColumnBuilder.newColumn('no_ttb').withTitle('No. TTB'),
        //     DTColumnBuilder.newColumn('total').withTitle('Jumlah (Rp)'),
        //     DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        // ];
        //
        // function createdRow(row, data, dataIndex) {
        //     $compile(angular.element(row).contents())($scope);
        // }
        //
        // // Action buttons added to the last column: to edit and to delete rows
        // function actionButtons(data, type, full, meta) {
        //     return '<button class="btn btn-warning btn-xs" ng-click="vm.addBapb(' + data.bapb_id + ')">' +
        //         '   <i class="fa fa-check"></i>' +
        //         '</button>&nbsp;'
        // }

        function noInvoice() {
            InvoiceService.no()
                .then(function (result) {
                    vm.input.invoice_no = result.data;
                    vm.input.invoice_no = result.data;
                });
        }

        function getBapbList() {
            InvoiceService.getBapbList({
                recipient_id: vm.input.recipient_id
            })
                .then(function (result) {
                    vm.bapbList = result.data.bapbList;
                });
        }

        vm.addBapb = bapb => {
            const dup = vm.newBapbList.find(i => i === bapb);
            if (dup) {
                return;
            }

            vm.bapbList.splice(vm.bapbList.indexOf(bapb), 1);

            vm.newBapbList.push(bapb);
        };

        vm.removeBapb = bapb => {
            vm.newBapbList.splice(vm.newBapbList.indexOf(bapb), 1);
            vm.bapbList.push(bapb);
        };

        vm.recipientAsyncPageLimit = 20;
        vm.recipientTotalResults = 0;

        vm.searchRecipientList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return RecipientService.search({
                params: {
                    text: searchText,
                    limit: vm.recipientAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    vm.recipientTotalResults = result.data.count;
                    vm.detail.recipientList = result.data.recipientList;
                    return result.data.recipientList;
                });
        };
        vm.getRecipientDetail = () => {
            if (!vm.input.recipient_id) {
                return;
            }

            // vm.dtInstance.reloadData();

            vm.detail.recipient = vm.detail.recipientList.find(i => i.recipient_id === vm.input.recipient_id);

            getBapbList();
        };


        vm.onSubmit = () => {
            let data = {
                invoice_no: vm.input.invoice_no,
                bapb_list: vm.newBapbList.map(i => i.bapb_id)
            };

            // if (!bapbIsValid(data)) {
            //     return;
            // }

            swangular.confirm('Konfirmasi INVOICE', {
                showCancelButton: true,
                preConfirm: () => {
                    InvoiceService.store(data)
                        .then(res => {
                            if (res.status == 'OK') {
                                swangular.success("Berhasil Menyimpan INVOICE", {
                                    preConfirm: function () {
                                        if (!vm.id) {
                                            $state.reload();
                                        } else {
                                            $state.go('admin.invoice');
                                        }
                                    }
                                });
                            } else {
                                swangular.alert("Error, terjadi kesalahan ketika memproses bapb");
                            }
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
