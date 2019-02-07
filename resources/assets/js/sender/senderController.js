;(() => {
    'use strict';

    angular
        .module('Ekspedisi.sender')
        .controller('SenderController', SenderController);

    SenderController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'SenderService'
    ];

    function SenderController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService) {
        let vm = this;

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/sender/',
                type: 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
                },
                dataSrc: json => {
                    vm.senderList = json.data;
                    return vm.senderList;
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
            DTColumnBuilder.newColumn('sender_code').withTitle('Kode Pengirim').withOption('width', '10%'),
            DTColumnBuilder.newColumn('sender_name').withTitle('Nama Pengirim'),
            DTColumnBuilder.newColumn('sender_name_bapb').withTitle('Nama Pengirim BAPB'),
            DTColumnBuilder.newColumn('sender_phone').withTitle('Telepon').withOption('width', '10%'),
            DTColumnBuilder.newColumn('city.city_code').withTitle('Kota').withOption('width', '10%'),
            DTColumnBuilder.newColumn('sender_address').withTitle('Alamat').withOption('font-size', '0.7em'),
            DTColumnBuilder.newColumn('ambil_di').withTitle('Ambil Di'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-warning btn-xs" ng-click="vm.editSender(' + data.sender_id + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="vm.deleteSender(' + data.sender_id + ')">' +
                '   DELETE' +
                '</button>';
        }

        vm.editSender = id => {
            $state.go('admin.sender-edit', {id: id});
        }

        vm.deleteSender = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    SenderService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Pengirim");
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
