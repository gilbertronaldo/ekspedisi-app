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
    }
})();
