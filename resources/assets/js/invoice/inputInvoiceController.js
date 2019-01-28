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
        'ShipService',
        '$http',
        'RecipientService',
        'SenderService',
        'BapbService'
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
        ShipService,
        $http,
        RecipientService,
        SenderService,
        BapbService
    ) {
        let vm = this;
        vm.input = {};
        vm.codeList = [
            {code_id: 1, name: 'BJM - Banjarmasin'},
            {code_id: 2, name: 'SMD - Samarinda'},
            {code_id: 3, name: 'BPP - Balikpapan'},
            {code_id: 4, name: 'MKS - Makassar'},
            {code_id: 5, name: 'KJ - Retur'},
        ];
        vm.code = 1;
        vm.detail = {};
        vm.id = $stateParams.id;

        vm.newBapbList = [];

        function resetForm() {
            vm.input = {};
            vm.detail = {};
        }

        function init() {
            if (!vm.id) {
            } else {
            }
        }

        init();

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/bapb?recipient_id=' + vm.input.recipient_id,
                type: 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
                },
                data: function (search) {
                    // fine tune what you need to send back here.
                    search.recipient_id = vm.input.recipient;
                    return search;
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
            DTColumnBuilder.newColumn('bapb_no').withTitle('No Bapb'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('Deskripsi'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
            DTColumnBuilder.newColumn('no_container').withTitle('No Container'),
            DTColumnBuilder.newColumn('no_seal').withTitle('Seal'),
            DTColumnBuilder.newColumn('no_ttb').withTitle('No. TTB'),
            DTColumnBuilder.newColumn('total').withTitle('Jumlah (Rp)'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-info btn-xs" ng-click="vm.addBapb(' + data.bapb_id + ')">' +
                '   <i class="fa fa-check"></i>' +
                '</button>&nbsp;'
        }

        vm.addBapb = id => {
            const bapb = vm.newBapbList.find(i => i.bapb_id === id);
            if (bapb) {
                return;
            }

            BapbService.get(id)
                .then(res => {
                    vm.newBapbList.push(res.data);
                })
                .catch(err => {
                    console.log(err);
                })
        };

        vm.removeBapb = idx => {
            vm.newBapbList.splice(idx, 1);
            console.log(vm.newBapbList);
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
        };


        vm.onSubmit = () => {
            let data = vm.input;
            data.senders = vm.senders;

            // if (!bapbIsValid(data)) {
            //     return;
            // }

            swangular.confirm('Konfirmasi BAPB', {
                showCancelButton: true,
                preConfirm: () => {
                    console.log(data);
                    BapbService.store(data)
                        .then(res => {
                            if (res.status == 'OK') {
                                swangular.success("Berhasil Menyimpan BAPB", {
                                    preConfirm: function () {
                                        if (!vm.id) {
                                            $state.reload();
                                        } else {
                                            $state.go('admin.bapb');
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
