;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('ContainerController', ContainerController);

    ContainerController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'SenderService',
        'BapbService'
    ];

    function ContainerController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService, BapbService) {
        let vm = this;

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/container/',
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
        vm.dtColumns = [
            DTColumnBuilder.newColumn('no_container').withTitle('No Container'),
            DTColumnBuilder.newColumn('no_seal').withTitle('No Seal'),
            DTColumnBuilder.newColumn('destination').withTitle('Tujuan'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('No. Voyage'),
            DTColumnBuilder.newColumn('ship_name').withTitle('Nama Kapal'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return `<button class="btn btn-success btn-xs" ng-click="vm.printBapb('${data._no_container}')">` +
                `   <i class="fa fa-print"></i>` +
                `</button>`;
        }

        vm.editBapb = id => {
            $state.go('admin.bapb-input', {id: id});
        }

        vm.printBapb = id => {
            console.log(id);
            const win = window.open(`http://${window.location.hostname}/api/bapb/export/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };

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
