;(() => {
    'use strict';

    angular
        .module('Ekspedisi.ship')
        .controller('ShipController', ShipController);

    ShipController.$inject = [
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder'
    ];

    function ShipController(swangular, $q, DTOptionsBuilder, DTColumnBuilder) {
        let vm = this;

        vm.dtInstance = {};
        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: '/api/ship/',
                type: 'GET',
                dataSrc: json => {
                    vm.shipList = json.data
                    return []
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
            DTColumnBuilder.newColumn('destination_name').withTitle('Tujuan'),
            DTColumnBuilder.newColumn('_sailing_date').withTitle('Tanggal Keberangkatan').withOption('width', '15%'),
            DTColumnBuilder.newColumn(null).withTitle('Action').notSortable().renderWith(actionButtons).withOption('searchable', false)
        ];
        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }
        // Action buttons added to the last column: to edit and to delete rows
        function actionButtons(data, type, full, meta) {
            return '<button class="btn btn-info btn-xs" ng-click="ctrl.editShip(' + data.ship_id + ')">' +
                '   <i class="fa fa-edit"></i>' +
                '</button>&nbsp;' +
                '<button class="btn btn-danger btn-xs" ng-click="ctrl.deleteShip(' + data.ship_id + ')">' +
                '   <i class="fa fa-trash-o"></i>' +
                '</button>';
        }
    }
})();
