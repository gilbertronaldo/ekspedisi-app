;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('InputBapbController', InputBapbController);

    InputBapbController.$inject = [
        '$state',
        '$stateParams',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'ShipService',
        '$http',
        'RecipientService',
        'SenderService',
        'BapbService'
    ];

    function InputBapbController(
        $state,
        $stateParams,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        ShipService,
        $http,
        RecipientService,
        SenderService,
        BapbService
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.detail = {};

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

        ctrl.id = $stateParams.id;

        function init() {
            if (!ctrl.id) {
                getNewBapbNo();
                ctrl.senders = [senderNew()];
            } else {
                getBapb();
            }
        }
        init();

        function getBapb() {
            BapbService.get(ctrl.id)
                .then(res => {
                    ctrl.input = res.data;
                    ctrl.senders = ctrl.input.senders;

                    ctrl.senders.forEach((i, idx) => {
                        i.total = {};
                        ctrl.senderItemCalculate(idx);
                    })

                    getShip();
                    getRecipient();
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getShip() {
            ShipService.get(ctrl.input.ship_id)
                .then(res => {
                    ctrl.detail.ship = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getRecipient() {
            RecipientService.get(ctrl.input.recipient_id)
                .then(res => {
                    ctrl.detail.recipient = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getNewBapbNo() {
            BapbService.no()
                .then(res => {
                    ctrl.input.bapb_no = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
        }

        ctrl.searchShipList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return ShipService.search({
                params: {
                    text: searchText,
                    limit: ctrl.shipAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    ctrl.shipTotalResults = result.data.total;
                    ctrl.detail.shipList = result.data.shipList;
                    return result.data.shipList;
                });
        };
        ctrl.getShipDetail = () => {
            if (!ctrl.input.ship_id) {
                return;
            }
            ctrl.detail.ship = ctrl.detail.shipList.find(i => i.ship_id === ctrl.input.ship_id);
        }

        ctrl.recipientAsyncPageLimit = 20;
        ctrl.recipientTotalResults = 0;

        ctrl.searchRecipientList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return RecipientService.search({
                params: {
                    text: searchText,
                    limit: ctrl.recipientAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    ctrl.recipientTotalResults = result.data.total;
                    ctrl.detail.recipientList = result.data.recipientList;
                    return result.data.recipientList;
                });
        };
        ctrl.getRecipientDetail = () => {
            if (!ctrl.input.recipient_id) {
                return;
            }
            ctrl.detail.recipient = ctrl.detail.recipientList.find(i => i.recipient_id === ctrl.input.recipient_id);
        }

        function senderNew() {
            return {
                'sender_id': null,
                'detail': {},
                'items': [senderItemNew()],
                'total': {
                    'koli': 0,
                    'dimensi': 0,
                    'berat': 0,
                    'harga': 0,
                }
            };
        }

        function senderItemNew() {
            return {
                'bapb_sender_item_id': null,
                'bapb_sender_item_name': null,
                'koli': null,
                'panjang': null,
                'lebar': null,
                'tinggi': null,
                'berat': null
            };
        }

        ctrl.senderPush = () => {
            ctrl.senders.push(senderNew());
        }

        ctrl.senderPop = () => {
            if (ctrl.senders.length === 1)
                return;
            ctrl.senders.pop();
        }

        ctrl.senderItemPush = (idx) => {
            ctrl.senders[idx].items.push(senderItemNew());
            ctrl.senderItemCalculate(idx);
        }

        ctrl.senderItemPop = (idx) => {
            if (ctrl.senders[idx].items.length === 1)
                return;
            ctrl.senders[idx].items.pop();
            ctrl.senderItemCalculate(idx);
        }

        ctrl.senderItemCalculate = (idx) => {
            ctrl.senders[idx].total.koli = 0;
            ctrl.senders[idx].total.dimensi = 0;
            ctrl.senders[idx].total.berat = 0;
            ctrl.senders[idx].total.harga = 0;
            ctrl.senders[idx].items.forEach(i => {

                const koli = parseInt(i.koli) || 0;
                const berat = parseInt(i.berat) || 0;
                const volume = (parseInt(i.panjang) || 0) * (parseInt(i.lebar) || 0) * (parseInt(i.tinggi) || 0);
                const dimension = (Math.round((volume * koli)) / 1000000);

                ctrl.senders[idx].total.koli += koli;
                ctrl.senders[idx].total.berat += (koli * berat);
                ctrl.senders[idx].total.dimensi += dimension;
            })
            ctrl.senders[idx].total.dimensi = parseFloat(ctrl.senders[idx].total.dimensi).toFixed(3);
            ctrl.senders[idx].total.berat = parseFloat(ctrl.senders[idx].total.berat / 1000).toFixed(3);
        };

        ctrl.senderAsyncPageLimit = 20;
        ctrl.senderTotalResults = 0;

        ctrl.searchSenderList = (searchText, page) => {
            if (!searchText) {
                return [];
            }

            return SenderService.search({
                params: {
                    text: searchText,
                    limit: ctrl.senderAsyncPageLimit,
                    page: page,
                }
            })
                .then(function (result) {
                    ctrl.senderTotalResults = result.data.total;
                    ctrl.detail.senderList = result.data.senderList;
                    return result.data.senderList;
                });
        };
        ctrl.getSenderDetail = (idx) => {
            if (!ctrl.senders[idx].sender_id) {
                return;
            }

            ctrl.senders[idx].detail = ctrl.detail.senderList.find(i => i.sender_id === ctrl.senders[idx].sender_id);
        }

        ctrl.onSubmit = () => {
            let data = ctrl.input;
            data.senders = ctrl.senders;

            swangular.confirm('Konfirmasi BAPB', {
                showCancelButton: true,
                preConfirm: () => {
                    console.log(data);
                    BapbService.store(data)
                        .then(res => {
                            console.log(res)
                            if (res.status == 'OK') {
                                swangular.success("Berhasil Menyimpan BAPB");
                                $state.go('admin.home');
                            } else {
                                swangular.alert("Error, terjadi kesalahan ketika memproses bapb");
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            swangular.alert("Error");
                        })
                },
            })
        }
    }
})();
