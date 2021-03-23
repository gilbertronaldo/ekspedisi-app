(function () {
    'use strict';

    const NAME = 'oneTimeIf';

    angular
        .module('Ekspedisi.app', [
                'ui.router',
                'ngStorage',
                'moment-picker',
                'Ekspedisi.admin',
                'Ekspedisi.user',
                'Ekspedisi.role',
                'Ekspedisi.auth',
                'Ekspedisi.master',
                'Ekspedisi.ship',
                'Ekspedisi.recipient',
                'Ekspedisi.sender',
                'Ekspedisi.bapb',
                'Ekspedisi.invoice',
                'Ekspedisi.payment',
                'Ekspedisi.search',
                'Ekspedisi.ppn',
                'Ekspedisi.tracing',
                'Ekspedisi.pajak',
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
        .controller('LayoutController', function ($localStorage, $location, $scope, HomeService) {
            let ctrl = this;
            $scope.loading = [false];

            $scope.username = 'Aldo';

            init();

            function init() {
                $scope.loading[0] = true;
                HomeService.init()
                    .then(function (res) {
                        $localStorage.authTasks = res.data.tasks;
                        $localStorage.authUser = res.data.user;

                        $scope.username = res.data.user.name;

                        $scope.loading[0] = false;
                    })
                    .catch(err => {
                        $scope.loading[0] = false;
                        console.log(err);
                    });
            }

            $scope.doLogout = () => {
                $localStorage.$reset();
                $location.path('/login');
            }
        })
        .directive(NAME, function (ngIfDirective) {
            const ngIf = ngIfDirective[0];

            return {
                transclude: ngIf.transclude,
                priority: ngIf.priority,
                terminal: ngIf.terminal,
                restrict: ngIf.restrict,
                link: function ($scope, $element, $attr) {
                    const value = $attr[NAME];
                    const yourCustomValue = $scope.$eval(value);

                    $attr.ngIf = function () {
                        return yourCustomValue;
                    };
                    ngIf.link.apply(ngIf, arguments);
                }
            };
        })
        .directive('uiCurrency', function ($filter, $parse, $locale) {

            // For input validation
            var isValid = function (val) {
                return angular.isNumber(val) && !isNaN(val);
            };

            // Helper for creating RegExp's
            var toRegExp = function (val) {
                var escaped = val.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                return new RegExp(escaped, 'g');
            };

            // Saved to your $scope/model
            var toModel = function (val) {

                // Locale currency support
                var decimal = toRegExp($locale.NUMBER_FORMATS.DECIMAL_SEP);
                var group = toRegExp($locale.NUMBER_FORMATS.GROUP_SEP);
                var currency = toRegExp($locale.NUMBER_FORMATS.CURRENCY_SYM);

                // Strip currency related characters from string
                val = val.replace(decimal, '').replace(group, '').replace(currency, '').trim();

                return parseInt(val, 10);
            };

            // Displayed in the input to users
            var toView = function (val) {
                return $filter('currency')(val, '', 0);
            };

            // Link to DOM
            var link = function ($scope, $element, $attrs, $ngModel) {
                $ngModel.$formatters.push(toView);
                $ngModel.$parsers.push(toModel);
                $ngModel.$validators.currency = isValid;

                $element.on('keyup', function () {
                    $ngModel.$viewValue = toView($ngModel.$modelValue);
                    $ngModel.$render();
                });
            };

            return {
                restrict: 'A',
                require: 'ngModel',
                link: link
            };
        });

    function run($rootScope, $http, $location, $localStorage, $locale) {

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            var publicPages = ['/login'];
            var restrictedPage = publicPages.indexOf($location.path()) === -1;
            if (restrictedPage && !$localStorage.currentUser) {
                event.preventDefault();
                $location.path('/login');
            }
        });

        $rootScope.$on('$locationChangeSuccess', function (event, next, current) {
            if ($location.path()) {
                const excludes = ['', 'admin'];
                const arr = $location.path().split('/').filter(i => !excludes.includes(i));

                const text = arr.join(' ').replace('-', ' ');

                const title = `S R S M`;
                document.title = `${title} | ${text}`;
            }
        });

        $locale.NUMBER_FORMATS.GROUP_SEP = ".";
        $locale.NUMBER_FORMATS.DECIMAL_SEP = ",";

        $rootScope.authCan = (tasks) => {
            tasks = tasks.split(",").map(item => item.trim());

            if (!$localStorage.authTasks) {
                return false;
            }

            return $localStorage.authTasks.some(r => tasks.indexOf(r) >= 0);
        }
    }
})();
