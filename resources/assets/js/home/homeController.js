;(() => {
    'use strict'

    angular
        .module('Ekspedisi.home')
        .controller('HomeController', HomeController);

    HomeController.$inject = [
        'swangular',
        'HomeService'
    ];

    function HomeController(
        swangular,
        HomeService
    ) {
        let ctrl = this;

        ctrl.header = {};

        ctrl.loading = [
          false,
          false
        ];

        init();
        function init() {
            getHeader();
            getCharts();
        }

        function getHeader() {
            ctrl.loading[0] = true;
            HomeService.header()
                .then(function (result) {
                    ctrl.header = result.data;
                    ctrl.loading[0] = false;
                })
                .catch(err => {
                    ctrl.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error Home Header");
                })
        }

        function getCharts() {
            ctrl.loading[1] = true;
            HomeService.header()
                .then(function (result) {
                    ctrl.loading[1] = false;

                    setTimeout(() => {
                        initChart1();
                    }, 500);
                })
                .catch(err => {
                    ctrl.loading[1] = false;
                    console.log(err);
                    swangular.alert("Error Home Header");
                })
        }

        function initChart1() {
            window.jQuery(function() {
                console.log('a');
                'use strict';
                // ==============================================================
                // Product Sales
                // ==============================================================
                Morris.Area({
                    element: 'product-sales',
                    data: [
                        {
                            period: '2012',
                            iphone: 50,
                            ipad: 80,
                            itouch: 20
                        },
                        {
                            period: '2013',
                            iphone: 130,
                            ipad: 100,
                            itouch: 80
                        },
                        {
                            period: '2014',
                            iphone: 80,
                            ipad: 60,
                            itouch: 70
                        },
                        {
                            period: '2015',
                            iphone: 70,
                            ipad: 200,
                            itouch: 140
                        },
                        {
                            period: '2016',
                            iphone: 180,
                            ipad: 150,
                            itouch: 140
                        },
                        {
                            period: '2017',
                            iphone: 105,
                            ipad: 100,
                            itouch: 80
                        },
                        {
                            period: '2018',
                            iphone: 250,
                            ipad: 150,
                            itouch: 200
                        }
                    ],
                    xkey: 'period',
                    ykeys: ['iphone', 'ipad'],
                    labels: ['iPhone', 'iPad'],
                    pointSize: 2,
                    fillOpacity: 0,
                    pointStrokeColors: ['#ccc', '#4798e8', '#9675ce'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 2,
                    hideHover: 'auto',
                    lineColors: ['#ccc', '#4798e8', '#9675ce'],
                    resize: true
                });
                // ==============================================================
                // City weather
                // ==============================================================
                var chart = new Chartist.Line(
                    '#ct-weather',
                    {
                        labels: ['1PM', '2PM', '3PM', '4PM', '5PM', '6PM'],
                        series: [[2, 0, 5, 2, 5, 2]]
                    },
                    {
                        showArea: true,
                        showPoint: false,

                        chartPadding: {
                            left: -35
                        },
                        axisX: {
                            showLabel: true,
                            showGrid: false
                        },
                        axisY: {
                            showLabel: false,
                            showGrid: true
                        },
                        fullWidth: true
                    }
                );
                // ==============================================================
                // Ct Barchart
                // ==============================================================
                new Chartist.Bar(
                    '#weeksales-bar',
                    {
                        labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                        series: [[50, 40, 30, 70, 50, 20, 30]]
                    },
                    {
                        axisX: {
                            showLabel: false,
                            showGrid: false
                        },

                        chartPadding: {
                            top: 15,
                            left: -25
                        },
                        axisX: {
                            showLabel: true,
                            showGrid: false
                        },
                        axisY: {
                            showLabel: false,
                            showGrid: false
                        },
                        fullWidth: true,
                        plugins: [Chartist.plugins.tooltip()]
                    }
                );
            });
        }
    }
})();
