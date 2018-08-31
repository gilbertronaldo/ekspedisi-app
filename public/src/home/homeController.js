;(() => {
    'use strict'

    angular
        .module('Ekspedisi.home')
        .controller('HomeController', HomeController);

    HomeController.$inject = [
        'swangular'
    ];

    function HomeController(swangular) {
        console.log(this)
        swangular.success("Great job!");
    }
})();
