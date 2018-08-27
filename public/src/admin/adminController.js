;(() => {
    'use strict'

    angular
        .module('Ekspedisi.admin')
        .controller('AdminController', AdminController);

    AdminController.$inject = [];

    function AdminController() {
        console.log(this)
    }
})();
