(function () {
    'use strict';

    angular
        .module('Ekspedisi.app', [
                'ui.router',
                'ngStorage',
                'moment-picker',
                'Ekspedisi.admin',
                'Ekspedisi.auth',
                'Ekspedisi.master',
                'Ekspedisi.ship',
                'Ekspedisi.recipient',
                'Ekspedisi.sender',
                'Ekspedisi.bapb'
            ],
            [
                '$interpolateProvider', '$urlRouterProvider', '$httpProvider',
                function ($interpolateProvider, $urlRouterProvider, $httpProvider) {
                    $urlRouterProvider.otherwise(function ($injector) {
                        return '/admin/home';
                    });
                    // $interpolateProvider.startSymbol('<%').endSymbol('%>');

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
        .run(run)
        .controller('LayoutController', function ($localStorage, $location, $scope) {
            let ctrl = this;

            $scope.doLogout = () => {
                $localStorage.$reset();
                $location.path('/login');
            }
        })
        .directive('uiCurrency', function ($filter, $parse) {
            return {
                require: 'ngModel',
                restrict: 'A',
                link: function (scope, element, attrs, ngModel) {

                    function parse(viewValue, noRender) {
                        if (!viewValue)
                            return viewValue;

                        // strips all non digits leaving periods.
                        var clean = viewValue.toString().replace(/[^0-9.]+/g, '').replace(/\.{2,}/, '.');

                        // case for users entering multiple periods throughout the number
                        var dotSplit = clean.split('.');
                        if (dotSplit.length > 2) {
                            clean = dotSplit[0] + '.' + dotSplit[1].slice(0, 2);
                        } else if (dotSplit.length == 2) {
                            clean = dotSplit[0] + '.' + dotSplit[1].slice(0, 2);
                        }

                        if (!noRender)
                            ngModel.$render();
                        return clean;
                    }

                    ngModel.$parsers.unshift(parse);

                    ngModel.$render = function () {
                        var clean = parse(ngModel.$viewValue, true);
                        if (!clean)
                            return;

                        var currencyValue,
                            dotSplit = clean.split('.');

                        // todo: refactor, this is ugly
                        if (clean[clean.length - 1] === '.') {
                            currencyValue = $filter('number')(parseFloat(clean)) + '.';

                        } else if (clean.indexOf('.') != -1 && dotSplit[dotSplit.length - 1].length == 1) {
                            currencyValue = $filter('number')(parseFloat(clean), 1);
                        } else if (clean.indexOf('.') != -1 && dotSplit[dotSplit.length - 1].length == 1) {
                            currencyValue = $filter('number')(parseFloat(clean), 2);
                        } else {
                            currencyValue = $filter('number')(parseFloat(clean));
                        }

                        element.val(currencyValue);
                    };

                }
            };
        });

    function run($rootScope, $http, $location, $localStorage, $locale) {
        // redirect to login page if not logged in and trying to access a restricted page
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            var publicPages = ['/login'];
            var restrictedPage = publicPages.indexOf($location.path()) === -1;
            if (restrictedPage && !$localStorage.currentUser) {
                event.preventDefault();
                $location.path('/login');
            }
        });

        $locale.NUMBER_FORMATS.GROUP_SEP = ".";
        $locale.NUMBER_FORMATS.DECIMAL_SEP = ",";
    }
})();
