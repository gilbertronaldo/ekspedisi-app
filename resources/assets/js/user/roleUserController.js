;(() => {
        'use strict';

        angular
            .module('Ekspedisi.user')
            .controller('RoleUserController', RoleUserController);

        RoleUserController.$inject = [
            '$state',
            '$scope',
            '$stateParams',
            'swangular',
            '$q',
            'DTOptionsBuilder',
            'DTColumnBuilder',
            '$localStorage',
            '$compile',
            'UserService',
            'RoleService',
            '$rootScope',
            '$timeout'
        ];

        function RoleUserController(
            $state,
            $scope,
            $stateParams,
            swangular,
            $q,
            DTOptionsBuilder,
            DTColumnBuilder,
            $localStorage,
            $compile,
            UserService,
            RoleService,
            $rootScope,
            $timeout) {

            console.log('keong');

            $scope.loading = [false];
            $scope.input = {
                id: null,
                name: null,
                email: null
            };
            $scope.userRoles = [
                {
                    user_id: $scope.input.id,
                    role_id: null,
                    city_code: null
                }
            ];

            $scope.roles = [];
            $scope.locations = [
                {city_code: 'JKT', name: 'JKT - Jakarta'},
                {city_code: 'BJM', name: 'BJM - Banjarmasin'},
                {city_code: 'SMD', name: 'SMD - Samarinda'},
                {city_code: 'BPP', name: 'BPP - Balikpapan'},
                {city_code: 'MKS', name: 'MKS - Makassar'},
            ];

            init();

            function init() {
                getUser();
                getRoles();
            }

            function getUser() {
                UserService.roles($stateParams.id)
                    .then(res => {
                        $scope.input = res.data.user;
                        $scope.userRoles = res.data.roles;
                    })
                    .catch(err => {
                        swangular.alert("Error");
                    })
            }

            function getRoles() {
                RoleService.all()
                    .then(res => {
                        $scope.roles = res.data.roleList;
                    })
                    .catch(err => {
                        swangular.alert("Error");
                    })
            }

            $scope.save = () => {
                swangular.confirm('Apakah anda yakin ingin menyimpan data ini', {
                    showCancelButton: true,
                    preConfirm: () => {
                        UserService.saveRoles($scope.input.id, {
                            roles: $scope.userRoles
                        })
                            .then(res => {
                                if (res.status === 'FAIL') {
                                    swangular.alert(res.data.message);
                                } else if (res.status === 'OK') {
                                    $state.go('admin.user');
                                    swangular.success("Data User Role Berhasil Tersimpan");
                                }
                            })
                            .catch(err => {
                                swangular.alert("Error");
                            })
                    }
                });
            };

            $scope.onPushUserRole = () => {
                $scope.userRoles.push({
                    user_id: $scope.input.id,
                    role_id: null,
                    city_code: null
                });
                console.log($scope.userRoles);
            };

            $scope.onPopUserRole = () => {
                $scope.userRoles.pop();
            };
        }
    }
)();
