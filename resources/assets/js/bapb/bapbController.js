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
        '$timeout'
    ];

    function BapbController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService, BapbService, $timeout) {
        let vm = this;

        $scope.a = true;

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
            DTColumnBuilder.newColumn('no_voyage').withTitle('Deskripsi'),
            DTColumnBuilder.newColumn('recipient_name_bapb').withTitle('Penerima'),
            DTColumnBuilder.newColumn('no_container').withTitle('No Container'),
            DTColumnBuilder.newColumn('no_seal').withTitle('Seal'),
            DTColumnBuilder.newColumn('no_ttb').withTitle('No. TTB'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-warning btn-xs" ng-click="vm.editBapb(' + data.bapb_id + ')">' +
                '   EDIT' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="vm.deleteBapb(' + data.bapb_id + ')">' +
                '   DELETE' +
                '</button>&nbsp;' +
                '<button class="btn btn-success btn-xs" ng-click="vm.printBapb(' + data.bapb_id + ')">' +
                '   {{ "PRINT" }}' +
                '</button>&nbsp;' +
                '<button class="btn btn-info btn-xs" ng-click="vm.verifyBapb(' + data.bapb_id + ')" ng-show="' + (data.verified == false) + '">' +
                '   {{ "VERIFY" }}' +
                '</button>';
        }

        vm.editBapb = id => {
            console.log(id)
            $state.go('admin.bapb-input', {id: id});
        }

        vm.printBapb = id => {
            const win = window.open(`http://${window.location.hostname}/api/bapb/generate/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

        vm.verifyBapb = id => {
            swangular.confirm('Apakah anda yakin ingin men verifying data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    BapbService.verify(id)
                        .then(res => {
                            swangular.success("Berhasil Verified Bapb");
                            vm.dtInstance.rerender();
                        })
                        .catch(err => {
                            console.log(err);
                            swangular.alert("Error");
                        })
                },
            })
        }

        vm.deleteBapb = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus data ini', {
                showCancelButton: true,
                preConfirm: () => {
                    BapbService.delete(id)
                        .then(res => {
                            swangular.success("Berhasil Menghapus Bapb");
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
