(function () {
    'use strict';

    angular
        .module('Ekspedisi.app', [
                'ui.router',
                'ngStorage',
                'moment-picker',
                'Ekspedisi.admin',
                'Ekspedisi.auth',
                'Ekspedisi.ship',
                'Ekspedisi.master'
            ],
            [
                '$interpolateProvider', '$urlRouterProvider', '$httpProvider',
                function ($interpolateProvider, $urlRouterProvider, $httpProvider) {
                    $urlRouterProvider.otherwise(function ($injector) {
                        return '/admin/home';
                    });
                    $interpolateProvider.startSymbol('<%').endSymbol('%>');

                    $httpProvider.interceptors.push(function ($q, $location, $localStorage) {
                        return {
                            'request': function (config) {
                                config.headers.Authorization = '';
                                $localStorage.$sync();
                                $localStorage.$apply();
                                if ($localStorage.currentUser) {
                                    config.headers.Authorization = 'Bearer ' + $localStorage.currentUser.access_token;
                                }
                                return config || $q.when(config);
                            },
                            // optional method
                            'requestError': function (rejection) {
                                return $q.reject(rejection);
                            },
                            'response': function (response) {
                                let data = response.data.result;
                                let _auth = true;
                                if (data) {
                                    if (data.status_code === 401 || data.data.message === 'Unauthenticated.') {
                                        _auth = false;
                                    }
                                }
                                if (_auth) {
                                    return response || $q.when(response);
                                } else {
                                    $localStorage.$reset();
                                    $location.path('/login');
                                }
                            },
                            // optional method
                            'responseError': function (rejection) {
                                if (rejection.status === 401) {
                                    $localStorage.$reset();
                                    $location.path('/login');
                                }
                                return $q.reject(rejection) || $q.when(rejection);
                            }
                        };
                    });
                }])
        .run(run);

    function run($rootScope, $http, $location, $localStorage) {
        // redirect to login page if not logged in and trying to access a restricted page
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            var publicPages = ['/login'];
            var restrictedPage = publicPages.indexOf($location.path()) === -1;
            if (restrictedPage && !$localStorage.currentUser) {
                event.preventDefault();
                $location.path('/login');
            }
        });
    }
})();
