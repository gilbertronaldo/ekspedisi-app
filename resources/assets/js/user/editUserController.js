;(() => {
        'use strict';

        angular
            .module('Ekspedisi.user')
            .controller('EditUserController', EditUserController);

        EditUserController.$inject = [
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
            '$rootScope',
            '$timeout'
        ];

        function EditUserController(
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
            $rootScope,
            $timeout) {

            $scope.editMode = $stateParams.id !== null;
            $scope.loading = [false];
            $scope.input = {
                id: null,
                name: null,
                email: null
            };

            init();

            function init() {
                if ($scope.editMode) {
                    getUser();
                }
            }

            function getUser() {
                UserService.get($stateParams.id)
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
                        UserService.save($scope.input)
                            .then(res => {
                                if (res.status === 'FAIL') {
                                    swangular.alert(res.data.message);
                                } else if (res.status === 'OK') {
                                    $state.go('admin.user');
                                    swangular.success("Data User Berhasil Tersimpan");
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
