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
        'BapbService',
        '$rootScope',
        '$timeout'
    ];

    function ContainerController($state, $scope, swangular, $q, DTOptionsBuilder, DTColumnBuilder, $localStorage, $compile, SenderService, BapbService, $rootScope, $timeout) {
        let vm = this;

        vm.can = {
            printExcel: $rootScope.authCan('CONTAINER_PRINT_EXCEL')
        };

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
            .withOption('drawCallback', function () {
                $timeout(() => {
                });
            });
        vm.dtColumns = [
            DTColumnBuilder.newColumn('no_container').withTitle('No Container'),
            DTColumnBuilder.newColumn('no_seal').withTitle('No Seal'),
            DTColumnBuilder.newColumn('destination').withTitle('Tujuan'),
            DTColumnBuilder.newColumn('no_voyage').withTitle('No. Voyage'),
            DTColumnBuilder.newColumn('ship_name').withTitle('Nama Kapal'),
            DTColumnBuilder.newColumn('sailing_date').withTitle('Tgl Brngkt'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];

        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            const noContainer = `'${data.no_voyage}'`;
            return '<div ng-controller="ContainerController"><button class="btn btn-success btn-xs" ng-click="printExcel('+ noContainer +')" one-time-if="(' + vm.can.printExcel + ')">'+
                'PRINT' +
                '</button></div>';
        }


        $scope.printExcel = id => {
            console.log(id);
            const win = window.open(`${window.location.href.split('/').slice(0, 3).join('/')}/api/bapb/export/${id}?token=${$localStorage.currentUser.access_token}`, '_blank');
            win.focus();
        };
    }
})();
