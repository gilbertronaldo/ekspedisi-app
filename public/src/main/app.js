(function () {
    'use strict';

    angular
        .module('Ekspedisi.app', [
                'Ekspedisi.home'
            ],
            [
                '$interpolateProvider',
                function ($interpolateProvider) {
                    $interpolateProvider.startSymbol('<%').endSymbol('%>');
                }]);
})();
