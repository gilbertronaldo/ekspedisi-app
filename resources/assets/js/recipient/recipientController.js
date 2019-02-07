;(() => {
    'use strict';

    angular
        .module('Ekspedisi.recipient')
        .controller('RecipientController', RecipientController);

    RecipientController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'RecipientService'
    ];

    function RecipientController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, RecipientService) {
        let vm = this;

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/recipient/',
                type: 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
                },
                dataSrc: json => {
                    vm.recipientList = json.data;
                    return vm.recipientList;
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
            DTColumnBuilder.newColumn('recipient_code').withTitle('Kode Penerima').withOption('width', '10%'),
            DTColumnBuilder.newColumn('recipient_name').withTitle('Nama Penerima'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Nama Penerima BAPB'),
            DTColumnBuilder.newColumn('recipient_phone').withTitle('Handphone').withOption('width', '10%'),
            DTColumnBuilder.newColumn('city.city_code').withTitle('Kota').withOption('width', '10%'),
            DTColumnBuilder.newColumn('recipient_address').withTitle('Alamat').withOption('font-size', '0.7em'),
            DTColumnBuilder.newColumn('ambil_di').withTitle('Ambil Di'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-info btn-xs" ng-click="vm.editRecipient(' + data.recipient_id + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="vm.deleteRecipient(' + data.recipient_id + ')">' +
                '   DELETE' +
                '</button>';
        }

        vm.editRecipient = id => {
            $state.go('admin.recipient-edit', {id: id});
        }

        vm.deleteRecipient = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    RecipientService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Penerima");
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
