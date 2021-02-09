;(() => {
    'use strict';

    angular
        .module('Ekspedisi.ppn')
        .controller('PpnController', PpnController);

    PpnController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'PpnService',
        '$rootScope',
        '$timeout',
        '$filter'
    ];

    function PpnController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, PpnService, $rootScope, $timeout, $filter) {
        let vm = this;

        vm.can = {
            edit: $rootScope.authCan('SHIP_EDIT'),
            delete: $rootScope.authCan('SHIP_DELETE')
        };

        vm.dtInstanceCallback = (dtInstance) => {
            vm.dtInstance = dtInstance;
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
                url: '/api/ppn/',
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
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });

        vm.fnRenderMoney = function (data, type, full) {
            return $filter('currency')(data, 'Rp. ', 0);
        };

        vm.dtColumns = [
            DTColumnBuilder.newColumn('customer').withTitle('Customer'),
            DTColumnBuilder.newColumn('invoice_no').withTitle('No. Invoice'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('No. Voyage'),
            DTColumnBuilder.newColumn('bapb_no').withTitle('No. Bapb'),
            DTColumnBuilder.newColumn('no_container').withTitle('No. Container'),
            DTColumnBuilder.newColumn('dpp').withTitle('DPP').renderWith(vm.fnRenderMoney),
            DTColumnBuilder.newColumn('ppn').withTitle('PPN').renderWith(vm.fnRenderMoney),
            DTColumnBuilder.newColumn('final').withTitle('Final').renderWith(vm.fnRenderMoney),
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<div ng-controller="ShipController"><button class="btn btn-warning btn-xs" ng-click="editShip(' + data.ship_id + ')" one-time-if="(' + vm.can.edit + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="deleteShip(' + data.ship_id + ')" one-time-if="(' + vm.can.delete + ')">' +
                '   DELETE' +
                '</button></div>';
        }

        $scope.editShip = shipId => {
            $state.go('admin.ship-edit', {id: shipId});
        }

        $scope.deleteShip = shipId => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    ShipService.delete(shipId)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Kapal");
                            // vm.dtInstance.rerender();
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
