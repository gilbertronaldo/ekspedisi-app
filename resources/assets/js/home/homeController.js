;(() => {
    'use strict'

    angular
        .module('Ekspedisi.home')
        .controller('HomeController', HomeController);

    HomeController.$inject = [
        'swangular',
        'HomeService'
    ];

    function HomeController(
        swangular,
        HomeService
    ) {
        let ctrl = this;

        ctrl.header = {};

        ctrl.loading = [
          false,
          false
        ];

        init();
        function init() {
            getHeader();
        }

        function getHeader() {
            ctrl.loading[0] = true;
            HomeService.header()
                .then(function (result) {
                    ctrl.header = result.data;
                    ctrl.loading[0] = false;
                })
                .catch(err => {
                    ctrl.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error Home Header");
                })
        }

    }
})();
