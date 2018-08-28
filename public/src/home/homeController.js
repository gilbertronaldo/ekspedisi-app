;(() => {
    'use strict'

    angular
        .module('Ekspedisi.home')
        .controller('HomeController', HomeController);

    HomeController.$inject = [];

    function HomeController() {
        console.log(this)
    }
})();
