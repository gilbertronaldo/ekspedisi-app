;(() => {
    'use strict'

    angular
        .module('Ekspedisi.ship')
        .controller('ShipController', ShipController);

    ShipController.$inject = [
        'swangular'
    ];

    function ShipController(swangular) {
        console.log(this)
        swangular.success("Great job!");
    }
})();
