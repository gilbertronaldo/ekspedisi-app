;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('BapbController', BapbController);

    BapbController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'SenderService',
        'BapbService',
        '$timeout',
        '$rootScope'
    ];

    function BapbController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService, BapbService, $timeout, $rootScope) {
        let vm = this;

        vm.can = {
            edit: $rootScope.authCan('BAPB_INPUT'),
            delete: $rootScope.authCan('BAPB_DELETE'),
            print: $rootScope.authCan('BAPB_PRINT_PDF'),
            verify: $rootScope.authCan('BAPB_VERIFY')
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
                url: '/api/bapb/',
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
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });
        vm.dtColumns = [
            DTColumnBuilder.newColumn('bapb_no').withTitle('No Bapb'),
            DTColumnBuilder.newColumn('senders').withTitle('Sender'),
            DTColumnBuilder.newColumn('no_ttb').withTitle('TTB'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
            DTColumnBuilder.newColumn('ship_name').withTitle('Kapal'),
            DTColumnBuilder.newColumn('sailing_date').withTitle('Brngkt'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('Voyage'),
            DTColumnBuilder.newColumn('no_container').withTitle('Cont'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<div ng-controller="BapbController">' +
                '<button class="btn btn-warning btn-xs" ng-click="editBapb(' + data.bapb_id + ')" one-time-if="(' + vm.can.edit + ')">' +
                '   VIEW' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="deleteBapb(' + data.bapb_id + ')" one-time-if="(' + vm.can.delete + ')">' +
                '   DELETE' +
                '</button>&nbsp;' +
                // '<button class="btn btn-success btn-xs" ng-click="printBapb(' + data.bapb_id + ')" one-time-if="(' + vm.can.print + ')">' +
                // '   {{ "PRINT" }}' +
                // '</button>&nbsp;' +
                '<button class="btn btn-info btn-xs" ng-click="verifyBapb(' + data.bapb_id + ')" one-time-if="' + (data.verified == false && vm.can.verify) + '">' +
                '   {{ "VERIFY" }}' +
                '</button></div>';
        }

        $scope.editBapb = id => {
            console.log(id)
            $state.go('admin.bapb-input', {id: id});
        }

        $scope.printBapb = id => {
            const win = window.open(`http://${window.location.hostname}/api/bapb/generate/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

        $scope.verifyBapb = id => {
            swangular.confirm('Apakah anda yakin ingin men verifying data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    BapbService.verify(id)
                        .then(res => {
                            swangular.success("Berhasil Verified Bapb");
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

        $scope.deleteBapb = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    BapbService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Bapb");
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
