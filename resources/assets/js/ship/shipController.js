;(() => {
    'use strict';

    angular
        .module('Ekspedisi.ship')
        .controller('ShipController', ShipController);

    ShipController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'ShipService'
    ];

    function ShipController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, ShipService) {
        let vm = this;

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/ship/',
                type: 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'Bearer ' + $localStorage.currentUser.access_token);
                },
                dataSrc: json => {
                    vm.shipList = json.data;
                    return vm.shipList;
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
            DTColumnBuilder.newColumn('no_voyage').withTitle('No. Voyage'),
            DTColumnBuilder.newColumn('ship_name').withTitle('Nama Kapal').withOption('width', '25%'),
            DTColumnBuilder.newColumn('ship_description').withTitle('Deskripsi'),
            DTColumnBuilder.newColumn('city_code_from').withTitle('Dari'),
            DTColumnBuilder.newColumn('city_code_to').withTitle('Ke'),
            DTColumnBuilder.newColumn('sailing_date').withTitle('Tanggal Keberangkatan').withOption('width', '15%'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-warning btn-xs" ng-click="vm.editShip(' + data.ship_id + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="vm.deleteShip(' + data.ship_id + ')">' +
                '   DELETE' +
                '</button>';
        }

        vm.editShip = shipId => {
            $state.go('admin.ship-edit', { id: shipId });
        }

        vm.deleteShip = shipId => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    ShipService.delete(shipId)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Kapal");
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
