;(() => {
    'use strict';

    angular
        .module('Ekspedisi.user')
        .controller('UserController', UserController);

    UserController.$inject = [
        '$state',
        '$scope',
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

    function UserController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        UserService,
        $rootScope,
        $timeout) {

        $scope.userList = [];
        $scope.loading = [false];
        $scope.password = null;

        init();

        function init() {
            getUserList();
        }

        function getUserList() {
            $scope.loading[0] = true;
            UserService.all()
                .then(res => {
                    $scope.userList = res.data.userList;
                    $scope.loading[0] = false;
                })
                .catch(err => {
                    $scope.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error");
                })
        }

        $scope.deleteUser = id => {
            swangular.confirm('Apakah anda yakin ingin menghapus user ini', {
                showCancelButton: true,
                preConfirm: () => {
                    UserService.destroy(id)
                        .then(res => {
                            getUserList();
                            swangular.success("Berhasil Menghapus User");
                        })
                        .catch(err => {
                            console.log(err);
                            swangular.alert("Error");
                        })
                },
            })
        }

        $scope.changePassword = id => {
            $scope.password = null;
            swangular.swal({
                type: 'warning',
                title: 'Ganti Password',
                html: '<input id="swal-password" class="form-control" type="text" ng-model="password" placeholder="Input Password baru user disini">',
                showCancelButton: true,
                confirmButtonText: 'Ganti Password!',
                preConfirm: function() {
                    return document.getElementById('swal-password').value;
                }
            }).then(function (res) {
                console.log(res);
                if (!res.value || res.value === true) {
                    $scope.password = null;
                    return;
                }

                UserService.changePassword({
                    id: id,
                    password: res.value,
                })
                    .then(res => {
                        swangular.success("Password berhasil terganti!");
                    })
                    .catch(err => {
                        console.log(err);
                        swangular.alert("Error");
                    })
            });
        }
    }
})();
