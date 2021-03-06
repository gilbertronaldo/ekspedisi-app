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
        'ShipService',
        '$rootScope',
        '$timeout'
    ];

    function ShipController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, ShipService, $rootScope, $timeout) {
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
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });
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
            return '<div ng-controller="ShipController"><button class="btn btn-warning btn-xs" ng-click="editShip(' + data.ship_id + ')" one-time-if="(' + vm.can.edit + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<div ng-controller="ShipController"><button class="btn btn-success btn-xs" ng-click="exportLangsungTagih(' + data.ship_id + ')">' +
                '   EXPORT LGSNG. TAGIH' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="deleteShip(' + data.ship_id + ')" one-time-if="(' + vm.can.delete + ')">' +
                '   DELETE' +
                '</button></div>';
        }

        $scope.editShip = shipId => {
            $state.go('admin.ship-edit', {id: shipId});
        }

        $scope.exportLangsungTagih = shipId => {
            const url = `${window.location.href.split('/').slice(0, 3).join('/')}/api/ship/export/${shipId}?token=${$localStorage.currentUser.access_token}`;
            const win = window.open(url, '_blank');
            win.focus();
        }

        $scope.deleteShip = shipId => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    ShipService.delete(shipId)
                        .then(res => {
                            if (res.status === 'OK') {
                                swangular.success("Berhasil Menghapus Kapal");
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
