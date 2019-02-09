;(() => {
        'use strict';

        angular
            .module('Ekspedisi.role')
            .controller('TaskRoleController', TaskRoleController);

        TaskRoleController.$inject = [
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

        function TaskRoleController(
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
            $scope.tasks = [];

            $scope.checkedAll = false;
            $scope.onCheckedAll = (ev) => {
                console.log(ev);
                $scope.tasks.forEach(i => {
                    i.checked = ev;
                })
            };

            $scope.onChecked = (idx) => {
                console.log(idx);
                $scope.checkedAll = $scope.tasks.filter(i => !i.checked).length === 0;
            };

            init();

            function init() {
                if ($scope.editMode) {
                    getRole();
                }
            }

            function getRole() {
                RoleService.tasks($stateParams.id)
                    .then(res => {
                        $scope.input = res.data.role;
                        $scope.tasks = res.data.tasks;
                    })
                    .catch(err => {
                        swangular.alert("Error");
                    })
            }

            $scope.save = () => {
                swangular.confirm('Apakah anda yakin ingin menyimpan data ini', {
                    showCancelButton: true,
                    preConfirm: () => {
                        const tasks = $scope.tasks.filter(i => i.checked).map(i => i.task_id);

                        RoleService.saveTasks($stateParams.id, {
                            tasks: tasks
                        })
                            .then(res => {
                                if (res.status === 'FAIL') {
                                    swangular.alert(res.data.message);
                                } else if (res.status === 'OK') {
                                    $state.go('admin.role');
                                    swangular.success("Data Role Tasks Berhasil Tersimpan");
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
