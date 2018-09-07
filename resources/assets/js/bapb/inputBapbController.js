;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('InputBapbController', InputBapbController);

    InputBapbController.$inject = [
        '$state',
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
        'SenderService'
    ];

    function InputBapbController(
        $state,
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
        SenderService
    ) {
        let ctrl = this;
        ctrl.input = {};
        ctrl.detail = {};

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

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

        ctrl.senders = [senderNew()];

        function senderNew() {
            return {
                'sender_id': null,
                'detail': {},
                'items': [senderItemNew()]
            };
        }

        function senderItemNew() {
            return {
                'sender_item_id': null,
                'sender_item_name': null,
                'koli': null,
                'panjang': null,
                'lebar': null,
                'tinggi': null,
                'ton': null
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
        }

        ctrl.senderItemPop = (idx) => {
            if (ctrl.senders[idx].items.length === 1)
                return;
            ctrl.senders[idx].items.pop();
        }

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
            console.log(data);
        }
    }
})();
