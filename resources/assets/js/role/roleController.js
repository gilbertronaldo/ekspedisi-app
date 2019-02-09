;(() => {
    'use strict';

    angular
        .module('Ekspedisi.role')
        .controller('RoleController', RoleController);

    RoleController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'RoleService',
        '$rootScope',
        '$timeout'
    ];

    function RoleController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        RoleService,
        $rootScope,
        $timeout) {


        $scope.roleList = [];
        $scope.loading = [false];

        init();
        function init() {
            getRoleList();
        }

        function getRoleList() {
            $scope.loading[0] = true;
            RoleService.all()
                .then(res => {
                    $scope.roleList = res.data.roleList;
                    $scope.loading[0] = false;
                })
                .catch(err => {
                    $scope.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error");
                })
        }

        $scope.delete = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus role ini', {
                showCancelButton: true,
                preConfirm: () => {
                    RoleService.destroy(id)
                        .then(res => {
                            getRoleList();
                            swangular.success("Berhasil Menghapus Role");
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
