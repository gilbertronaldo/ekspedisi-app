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
        'SenderService',
        '$rootScope',
        '$timeout'
    ];

    function SenderController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService, $rootScope, $timeout) {
        let vm = this;

        vm.can = {
            edit: $rootScope.authCan('SENDER_EDIT'),
            delete: $rootScope.authCan('SENDER_DELETE')
        };

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
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });
        vm.dtColumns = [
            DTColumnBuilder.newColumn('sender_code').withTitle('Kode Pengirim').withOption('width', '10%'),
            DTColumnBuilder.newColumn('sender_name_bapb').withTitle('Nama Pengirim BAPB'),
            DTColumnBuilder.newColumn('price').withTitle('Harga'),
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
            return '<div ng-controller="SenderController"><button class="btn btn-warning btn-xs" ng-click="editSender(' + data.sender_id + ')" one-time-if="(' + vm.can.edit + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="deleteSender(' + data.sender_id + ')" one-time-if="(' + vm.can.delete + ')">' +
                '   DELETE' +
                '</button></div>';
        }

        $scope.editSender = id => {
            $state.go('admin.sender-edit', {id: id});
        }

        $scope.deleteSender = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    SenderService.delete(id)
                        .then(res => {
                            if (res.status === 'OK') {
                                swangular.success("Berhasil Menghapus Pengirim");
                                $state.reload();
                            } else {
                                swangular.alert(res.data.message);
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
