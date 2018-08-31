(() => {
    'use strict';

    angular
        .module('Ekspedisi.admin', [
            'ui.router',
            'ui.bootstrap',
            'Ekspedisi.home'
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin', {
                url: '/admin',
                templateUrl: '/admin',
                abstract:true
            })
    });
})();
