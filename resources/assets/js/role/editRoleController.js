;(() => {
        'use strict';

        angular
            .module('Ekspedisi.role')
            .controller('EditRoleController', EditRoleController);

        EditRoleController.$inject = [
            '$state',
            '$scope',
            '$stateParams',
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

        function EditRoleController(
            $state,
            $scope,
            $stateParams,
            swangular,
            $q,
            DTOptionsBuilder,
            DTColumnBuilder,
            $localStorage,
            $compile,
            RoleService,
            $rootScope,
            $timeout) {

            $scope.editMode = $stateParams.id !== null;
            $scope.loading = [false];
            $scope.input = {
                role_id: null,
                role_name: null,
            };

            init();

            function init() {
                if ($scope.editMode) {
                    getRole();
                }
            }

            function getRole() {
                RoleService.get($stateParams.id)
                    .then(res => {
                        $scope.input = res.data;
                    })
                    .catch(err => {
                        swangular.alert("Error");
                    })
            }

            $scope.save = () => {
                swangular.confirm('Apakah anda yakin ingin menyimpan data ini', {
                    showCancelButton: true,
                    preConfirm: () => {
                        RoleService.save($scope.input)
                            .then(res => {
                                if (res.status === 'FAIL') {
                                    swangular.alert(res.data.message);
                                } else if (res.status === 'OK') {
                                    $state.go('admin.role');
                                    swangular.success("Data Role Berhasil Tersimpan");
                                }
                            })
                            .catch(err => {
                                swangular.alert("Error");
                            })
                    }
                });
            }

        }
    }

)();
