(() => {
    'use strict';

    angular
        .module('Ekspedisi.search', [
            'ui.router',
            'ui.bootstrap',
            'swangular',
            'datatables',
        ]).config(($stateProvider) => {
        $stateProvider
            .state('admin.search', {
                url: '/search',
                templateUrl: '/search',
                controller: 'SearchController as searchController',
            })

    });
})();
