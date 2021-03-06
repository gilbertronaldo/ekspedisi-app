;(() => {
    'use strict';

    angular
        .module('Ekspedisi.bapb')
        .controller('InputBapbController', InputBapbController);

    InputBapbController.$inject = [
        '$window',
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
        $window,
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

        $scope.isSaving = false;

        let ctrl = this;
        ctrl.is_admin = $localStorage.authUser.roles.some(r => ['ADMIN', 'SUPERADMIN'].includes(r));
        ctrl.can_edit = false;
        ctrl.next_id = 0;
        ctrl.input = {};
        ctrl.codeList = [
            /**
             * JKT
             */
            {code_id: '01', name: 'JB # JKT - BJM (Banjarmasin)'},
            {code_id: '02', name: 'JM # JKT - SMD (Samarinda)'},
            {code_id: '03', name: 'JP # JKT - BPP (Balikpapan)'},
            {code_id: '04', name: 'JK # JKT - MKS (Makassar)'},
            {code_id: '05', name: 'BJ # BJM - JKT (Retur)'},

            /**
             * SBY
             */
            {code_id: '11', name: 'SB # SBY - BJM (Banjarmasin)'},
            {code_id: '12', name: 'SM # SBY - SMD (Samarinda)'},
            {code_id: '13', name: 'SP # SBY - BPP (Balikpapan)'},
            {code_id: '14', name: 'SK # SBY - MKS (Makassar)'},
            {code_id: '15', name: 'SJ # BJM - SBY (Retur)'},
        ];
        ctrl.code = '01';
        ctrl.detail = {};
        ctrl.detail.calculation = {
            price_ton: 0,
            price_meter: 0,
            price_document: 0,
            minimum_charge: 0,
            minimum_charge_calculation_id: 0,
        };

        ctrl.minimumChargeCalculationList = [
            {
                calculation_id: 1,
                calculation_name: 'Meter Kubik'
            },
            {
                calculation_id: 2,
                calculation_name: 'Rp'
            },
            {
                calculation_id: 3,
                calculation_name: 'Kg'
            }
        ];

        ctrl.shipAsyncPageLimit = 20;
        ctrl.shipTotalResults = 0;

        ctrl.id = $stateParams.id;

        ctrl.fullContainer = {
            price: 0,
            items: [fullContainerItemNew()],
            costs: [fullContainerCostNew()],
            description: null,
        };

        function resetForm() {
            ctrl.input = {};
            ctrl.detail = {};
            ctrl.detail.calculation = {
                price_ton: 0,
                price_meter: 0,
                price_document: 0,
                minimum_charge: 0,
                minimum_charge_calculation_id: 0
            };
            getNewBapbNo();
            latestBapb();
            ctrl.senders = [senderNew()];
        }

        function init() {
            if (!ctrl.id) {
                resetForm();
                getNextId();
                ctrl.can_edit = true;
            } else {
                getBapb();
                ctrl.next_id = ctrl.id;
            }
        }

        function getNextId() {
            BapbService.next()
                .then(res => {
                    ctrl.next_id = parseInt(res.data);
                    console.log(ctrl.next_id);
                })
                .catch(err => {
                    console.log(err);
                })
        }

        init();

        ctrl.changeCode = () => {
            console.log(ctrl.code);
            resetForm();
        };

        function getBapb() {
            BapbService.get(ctrl.id)
                .then(res => {
                    res.data.no_container_2 = parseInt(res.data.no_container_2);
                    ctrl.input = res.data;
                    ctrl.input.langsung_tagih = ctrl.input.langsung_tagih === true ? 'true' : 'false';
                    console.log(res.data);
                    validateCanEdit();
                    getShip();
                    getRecipient();
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function validateCanEdit() {
            console.log('is_admin', ctrl.is_admin);
            console.log('roles', $localStorage.authUser.roles);
            // !(vm.input.verified && !vm.is_admin)
            if (ctrl.is_admin) {
                ctrl.can_edit = true;
                return;
            }

            if (!ctrl.input.verified) {
                ctrl.can_edit = true;
            }
        }

        function latestBapb() {
            BapbService.latest(ctrl.code)
                .then(res => {
                    if (res.data.latestBapb) {
                        console.log(res.data.latestBapb);
                        ctrl.input.tagih_di = res.data.latestBapb.tagih_di;
                        ctrl.input.ship_id = res.data.latestBapb.ship_id;
                        ctrl.input.no_container_1 = res.data.latestBapb.no_container_1;
                        ctrl.input.no_container_2 = parseInt(res.data.latestBapb.no_container_2);
                        ctrl.input.no_seal = parseInt(res.data.latestBapb.no_seal);

                        if (res.data.latestBapb.ship_id) {
                            getShip();
                        }
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getShip() {
            ShipService.get(ctrl.input.ship_id)
                .then(res => {
                    ctrl.detail.ship = res.data;

                    const code = ctrl.codeList.find(code =>
                        code.name.substr(11, 3) === ctrl.detail.ship.city_to.city_code
                        && code.name.substr(5, 3) === ctrl.detail.ship.city_from.city_code
                    );
                    console.log(code, ctrl.detail.ship);
                    ctrl.code = code.code_id;
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getRecipient() {
            RecipientService.get(ctrl.input.recipient_id)
                .then(res => {
                    ctrl.detail.recipient = res.data;
                    ctrl.detail.recipient.city_code = res.data.city ? res.data.city.city_code : '';

                    console.log(parseInt(ctrl.code));
                    if (parseInt(ctrl.code) >= 11 && parseInt(ctrl.code) <= 15) {
                        ctrl.detail.recipient.price_ton = parseInt(ctrl.detail.recipient.price_ton_surabaya || 0);
                        ctrl.detail.recipient.price_meter = parseInt(ctrl.detail.recipient.price_meter_surabaya || 0);
                        ctrl.detail.recipient.price_document = parseInt(ctrl.detail.recipient.price_document_surabaya || 0);
                        ctrl.detail.recipient.minimum_charge = parseInt(ctrl.detail.recipient.minimum_charge_surabaya || 0);
                        ctrl.detail.recipient.minimum_charge_calculation_id = parseInt(ctrl.detail.recipient.minimum_charge_calculation_id_surabaya || 0);
                    }

                    if (ctrl.input.tagih_di !== 'sender') {
                        ctrl.detail.calculation.price_ton = parseInt(ctrl.detail.recipient.price_ton || 0);
                        ctrl.detail.calculation.price_meter = parseInt(ctrl.detail.recipient.price_meter || 0);
                        ctrl.detail.calculation.price_document = parseInt(ctrl.detail.recipient.price_document || 0);
                        ctrl.detail.calculation.minimum_charge = parseInt(ctrl.detail.recipient.minimum_charge || 0);
                        ctrl.detail.calculation.minimum_charge_calculation_id = parseInt(ctrl.detail.recipient.minimum_charge_calculation_id || 0);
                    }

                    ctrl.senders = ctrl.input.senders;

                    ctrl.senders.forEach((i, idx) => {
                        if (i.entry_date) {
                            i.entry_date = moment(i.entry_date);
                        }
                        i.total = {};

                        console.log(i);
                        i.detail.price_ton = parseInt(i.detail.price_ton || 0);
                        i.detail.price_meter = parseInt(i.detail.price_meter || 0);
                        i.detail.price_document = parseInt(i.detail.price_document || 0);
                        i.detail.minimum_charge = parseInt(i.detail.minimum_charge || 0);
                        i.detail.minimum_charge_calculation_id = parseInt(i.detail.minimum_charge_calculation_id || 0);

                        ctrl.senderItemCalculate(idx);
                    })

                    if (ctrl.input.full_container) {
                        ctrl.fullContainer = ctrl.input.full_container_data;

                        ctrl.fullContainer.items.forEach(item => {

                            SenderService.get(item.sender_id)
                                .then(function (result) {
                                    item.sender_detail = result.data;
                                });
                        });

                        ctrl.fullContainerCalculate();
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }

        function getNewBapbNo() {
            BapbService.no(ctrl.code)
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
                    ctrl.shipTotalResults = result.data.count;
                    ctrl.detail.shipList = result.data.shipList;
                    return result.data.shipList;
                });
        };
        ctrl.getShipDetail = () => {
            if (!ctrl.input.ship_id) {
                return;
            }
            const ship = ctrl.detail.shipList.find(i => i.ship_id === ctrl.input.ship_id);
            const code = ctrl.codeList.find(i => i.code_id === ctrl.code);
            console.log(ctrl.detail, code, ship);
            if (ship && ctrl.code !== '05' && ctrl.code !== '15') {
                if (code.name.substr(11, 3) != ship.city_code_to) {
                    ctrl.input.ship_id = null;
                    ctrl.detail.ship = {};
                    swangular.alert("Kode BAPB dengan asal kapal tidak sesuai");
                    return;
                }
            }

            ctrl.detail.ship = ship;
        };

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
                    ctrl.recipientTotalResults = result.data.count;
                    ctrl.detail.recipientList = result.data.recipientList;
                    return result.data.recipientList;
                });
        };
        ctrl.getRecipientDetail = () => {
            if (!ctrl.input.recipient_id) {
                return;
            }

            const recipient = ctrl.detail.recipientList.find(i => i.recipient_id === ctrl.input.recipient_id);
            const code = ctrl.codeList.find(i => i.code_id === ctrl.code);
            console.log(ctrl.detail, recipient);
            if (recipient && ctrl.code !== '05' && ctrl.code !== '15') {
                if (ctrl.detail.ship.city_code_to !== recipient.city_code) {
                    ctrl.input.recipient_id = null;
                    ctrl.detail.recipient = {};
                    swangular.alert("Kode BAPB dengan kota penerima tidak sesuai");
                    return;
                }
            }

            ctrl.detail.recipient = ctrl.detail.recipientList.find(i => i.recipient_id === ctrl.input.recipient_id);

            if (parseInt(ctrl.code) >= 11 && parseInt(ctrl.code) <= 15) {
                ctrl.detail.recipient.price_ton = parseInt(ctrl.detail.recipient.price_ton_surabaya || 0);
                ctrl.detail.recipient.price_meter = parseInt(ctrl.detail.recipient.price_meter_surabaya || 0);
            }

            ctrl.changeCalculation();
        };

        function senderNew() {
            return {
                'sender_id': null,
                'kemasan': null,
                'krani': null,
                'entry_date': null,
                'detail': {},
                'items': [senderItemNew()],
                'costs': [senderCostNew()],
                'total': {
                    'koli': 0,
                    'dimensi': 0,
                    'berat': 0,
                    'harga': 0,
                    'cost': 0
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

        function senderCostNew() {
            return {
                'bapb_sender_cost_id': null,
                'bapb_sender_cost_name': null,
                'price': null,
            };
        }

        ctrl.senderPush = () => {
            ctrl.senders.push(senderNew());
        }

        ctrl.senderPop = () => {
            if (ctrl.senders.length === 1)
                return;
            ctrl.senders.pop();
            ctrl.senderItemCalculateAll();
        };

        ctrl.senderSplice = (idx) => {
            if (ctrl.senders.length === 1)
                return;
            ctrl.senders.splice(idx, 1);
            ctrl.senderItemCalculateAll();
        };

        ctrl.senderItemPush = (idx) => {
            ctrl.senders[idx].items.push(senderItemNew());
            ctrl.senderItemCalculate(idx);
        }

        ctrl.senderItemPop = (idx) => {
            if (ctrl.senders[idx].items.length === 1)
                return;
            ctrl.senders[idx].items.pop();
            ctrl.senderItemCalculate(idx);
        };

        ctrl.senderCostPush = (idx) => {
            ctrl.senders[idx].costs.push(senderCostNew());
            ctrl.senderItemCalculate(idx);
        };

        ctrl.senderCostPop = (idx) => {
            ctrl.senders[idx].costs.pop();
            ctrl.senderItemCalculate(idx);
        };

        function fullContainerItemNew() {
            return {
                'id': null,
                'sender_id': null,
                'name': null,
                'koli': null,
                'sender_detail': null,
            };
        }

        ctrl.fullContainerItemPop = () => {
            ctrl.fullContainer.items.pop();
        }

        ctrl.fullContainerItemPush = () => {
            ctrl.fullContainer.items.push(fullContainerItemNew());
        }

        function fullContainerCostNew() {
            return {
                'id': null,
                'name': null,
                'price': null,
            };
        }

        ctrl.fullContainerCostPop = () => {
            ctrl.fullContainer.costs.pop();
        }

        ctrl.fullContainerCostPush = () => {
            ctrl.fullContainer.costs.push(fullContainerCostNew());
        }

        ctrl.getSenderDetailFullContainer = (idx) => {
            if (!ctrl.fullContainer.items[idx].sender_id) {
                return;
            }

            ctrl.fullContainer.items[idx].sender_detail = ctrl.detail.senderList.find(i => i.sender_id === ctrl.fullContainer.items[idx].sender_id);
            ctrl.senderItemCalculateAll()
        }

        ctrl.fullContainerCalculate = () => {

            ctrl.input.total = {};
            ctrl.input.total.koli = 0;
            ctrl.input.total.dimensi = 0;
            ctrl.input.total.berat = 0;
            ctrl.input.total.harga = 0;
            ctrl.input.total.cost = 0;

            ctrl.fullContainer.items.forEach(item => {
                ctrl.input.total.koli += item.koli;
            })
            ctrl.fullContainer.costs.forEach(item => {
                ctrl.input.total.cost += item.price;
            })

            ctrl.input.total.harga += ctrl.fullContainer.price;
            ctrl.input.total.harga += ctrl.detail.calculation.price_document;
        }

        ctrl.changeCalculation = () => {
            if (ctrl.input.tagih_di != 'sender') {
                if (ctrl.input.recipient_id) {
                    ctrl.detail.calculation.price_ton = parseInt(ctrl.detail.recipient.price_ton || 0);
                    ctrl.detail.calculation.price_meter = parseInt(ctrl.detail.recipient.price_meter || 0);
                    ctrl.detail.calculation.price_document = parseInt(ctrl.detail.recipient.price_document || 0);
                    ctrl.detail.calculation.minimum_charge = parseInt(ctrl.detail.recipient.minimum_charge || 0);
                    ctrl.detail.calculation.minimum_charge_calculation_id = parseInt(ctrl.detail.recipient.minimum_charge_calculation_id || 0);
                }
            } else {
                ctrl.detail.calculation = {
                    price_ton: 0,
                    price_meter: 0,
                    price_document: 0,
                    minimum_charge: 0,
                    minimum_charge_calculation_id: 0,
                };
            }

            ctrl.senderItemCalculateAll();
        };

        ctrl.senderItemCalculateAll = () => {
            if (ctrl.input.full_container) {
                ctrl.fullContainerCalculate();
                return;
            }

            ctrl.senders.forEach((item, idx) => {
                ctrl.senderItemCalculate(idx);
            });
        };

        ctrl.senderItemCalculate = (idx) => {
            ctrl.senders[idx].total.koli = 0;
            ctrl.senders[idx].total.dimensi = 0;
            ctrl.senders[idx].total.berat = 0;
            ctrl.senders[idx].total.harga = 0;
            ctrl.senders[idx].total.cost = 0;

            const price_ton = ctrl.input.tagih_di !== 'sender' ? ctrl.detail.calculation.price_ton : parseInt(ctrl.senders[idx].detail.price_ton | 0);
            const price_meter = ctrl.input.tagih_di !== 'sender' ? ctrl.detail.calculation.price_meter : parseInt(ctrl.senders[idx].detail.price_meter | 0);
            const price_document = ctrl.input.tagih_di !== 'sender' ? ctrl.detail.calculation.price_document : parseInt(ctrl.senders[idx].detail.price_document | 0);

            const minimum_charge_calculation_id = ctrl.input.tagih_di !== 'sender' ? ctrl.detail.calculation.minimum_charge_calculation_id : ctrl.senders[idx].detail.minimum_charge_calculation_id;
            const min_charge = ctrl.input.tagih_di !== 'sender' ? ctrl.detail.calculation.minimum_charge : parseInt(ctrl.senders[idx].detail.minimum_charge | 0);

            ctrl.senders[idx].items.forEach(item => {

                const koli = parseInt(item.koli) || 0;
                const volume = (parseInt(item.panjang) || 0) * (parseInt(item.lebar) || 0) * (parseInt(item.tinggi) || 0);
                const dimension = (parseFloat(volume * koli) / 1000000).toFixed(3);
                const berat = parseFloat(koli * (parseInt(item.berat) || 0) / 1000).toFixed(3);

                item.total = {
                    dimensi: parseFloat(dimension),
                    berat: parseFloat(berat)
                };

                let price = 0;

                if (item.total.dimensi !== 0) {
                    price = item.total.dimensi * price_meter;
                }
                if (item.total.berat !== 0) {
                    price = item.total.berat * price_ton;
                }

                item.price = price;

                ctrl.senders[idx].total.koli += koli;
                ctrl.senders[idx].total.dimensi += item.total.dimensi;
                ctrl.senders[idx].total.berat += item.total.berat;
            });

            if (ctrl.input.tagih_di === 'sender') {
                if (minimum_charge_calculation_id === 1 || minimum_charge_calculation_id === 3) {
                    const biggest = ctrl.senders[idx].total.dimensi > ctrl.senders[idx].total.berat ? ctrl.senders[idx].total.dimensi : ctrl.senders[idx].total.berat;

                    const total_ = ctrl.senders[idx].total.dimensi + ctrl.senders[idx].total.berat;

                    if (total_ !== 0) {
                        if (total_ < parseFloat((min_charge / 1000).toFixed(3))) {

                            if (biggest === ctrl.senders[idx].total.dimensi) {
                                ctrl.senders[idx].total.dimensi = parseFloat((min_charge / 1000).toFixed(3));
                                ctrl.senders[idx].total.berat = 0;
                            } else {
                                ctrl.senders[idx].total.berat = parseFloat((min_charge / 1000).toFixed(3));
                                ctrl.senders[idx].total.dimensi = 0;
                            }

                        }
                    }

                    // if (ctrl.senders[idx].total.dimensi !== 0) {
                    //     if (ctrl.senders[idx].total.dimensi < parseFloat((min_charge / 1000).toFixed(3))) {
                    //         ctrl.senders[idx].total.dimensi = parseFloat((min_charge / 1000).toFixed(3));
                    //     }
                    // }
                    // if (ctrl.senders[idx].total.berat !== 0) {
                    //     if (ctrl.senders[idx].total.berat < parseFloat((min_charge / 1000).toFixed(3))) {
                    //         ctrl.senders[idx].total.berat = parseFloat((min_charge / 1000).toFixed(3));
                    //     }
                    // }
                }
            }

            let harga = 0;

            ctrl.senders[idx].total_dimensi = null;
            ctrl.senders[idx].total_berat = null;

            if (ctrl.senders[idx].total.dimensi !== 0) {
                harga += ctrl.senders[idx].total.dimensi * price_meter;
                ctrl.senders[idx].total_dimensi = ctrl.senders[idx].total.dimensi;
            }
            if (ctrl.senders[idx].total.berat !== 0) {
                harga += ctrl.senders[idx].total.berat * price_ton;
                ctrl.senders[idx].total_berat = ctrl.senders[idx].total.berat;
            }

            if (ctrl.input.tagih_di === 'sender') {
                if (minimum_charge_calculation_id !== 1 && minimum_charge_calculation_id !== 3) {
                    if (harga < min_charge) {
                        harga = min_charge;
                    }
                }
            }

            ctrl.senders[idx].total.harga = harga;

            reCalculateBiayaLainLainSender(idx);

            ctrl.senders[idx].total_price = ctrl.senders[idx].total.harga + ctrl.senders[idx].total.cost;

            reCalculateTotal();
        };

        function reCalculateBiayaLainLainSender(idx) {
            ctrl.senders[idx].costs.forEach(i => {
                ctrl.senders[idx].total.cost += parseInt(i.price) || 0;
            });
            ctrl.senders[idx].total.cost = parseInt(ctrl.senders[idx].total.cost);
        }

        function reCalculateTotal() {

            const price_ton = ctrl.detail.calculation.price_ton;
            const price_meter = ctrl.detail.calculation.price_meter;
            const price_document = ctrl.detail.calculation.price_document;

            const minimum_charge_calculation_id = ctrl.detail.calculation.minimum_charge_calculation_id;
            const min_charge = ctrl.detail.calculation.minimum_charge;

            let total_price_document = 0;

            ctrl.input.total = {};
            ctrl.input.total.koli = 0;
            ctrl.input.total.dimensi = 0;
            ctrl.input.total.berat = 0;
            ctrl.input.total.harga = 0;
            ctrl.input.total.cost = 0;
            ctrl.senders.forEach(i => {
                ctrl.input.total.koli += parseFloat(i.total ? i.total.koli : 0 || 0);
                ctrl.input.total.dimensi += parseFloat(i.total ? i.total.dimensi : 0 || 0);
                ctrl.input.total.berat += parseFloat(i.total ? i.total.berat : 0 || 0);
                ctrl.input.total.harga += parseFloat(i.total ? i.total.harga : 0 || 0);
                ctrl.input.total.cost += parseFloat(i.total ? i.total.cost : 0 || 0);

                // price document sender
                total_price_document += ctrl.input.tagih_di === 'sender' ? parseInt(i.detail.price_document || 0) : 0;
            });

            if (ctrl.input.tagih_di !== 'sender') {

                // price document recipient
                total_price_document = ctrl.detail.calculation.price_document;

                if (minimum_charge_calculation_id === 1 || minimum_charge_calculation_id === 3) {

                    const biggest = ctrl.input.total.dimensi > ctrl.input.total.berat ? ctrl.input.total.dimensi : ctrl.input.total.berat;

                    const total_ = ctrl.input.total.dimensi + ctrl.input.total.berat;

                    if (total_ != 0) {
                        if (total_ < parseFloat((min_charge / 1000).toFixed(3))) {

                            if (biggest === ctrl.input.total.dimensi) {
                                ctrl.input.total.dimensi = parseFloat((min_charge / 1000).toFixed(3));
                                ctrl.input.total.berat = 0;
                            } else {
                                ctrl.input.total.berat = parseFloat((min_charge / 1000).toFixed(3));
                                ctrl.input.total.dimensi = 0;
                            }

                        }
                    }

                    // if (ctrl.input.total.dimensi !== 0) {
                    //     if (ctrl.input.total.dimensi < parseFloat((min_charge / 1000).toFixed(3))) {
                    //         ctrl.input.total.dimensi = parseFloat((min_charge / 1000).toFixed(3));
                    //     }
                    // }
                    // if (ctrl.input.total.berat !== 0) {
                    //     if (ctrl.input.total.berat < parseFloat((min_charge / 1000).toFixed(3))) {
                    //         ctrl.input.total.berat = parseFloat((min_charge / 1000).toFixed(3));
                    //     }
                    // }
                }

                let harga = 0;

                if (ctrl.input.total.dimensi !== 0) {
                    harga += ctrl.input.total.dimensi * price_meter;
                }
                if (ctrl.input.total.berat !== 0) {
                    harga += ctrl.input.total.berat * price_ton;
                }

                if (minimum_charge_calculation_id !== 1 && minimum_charge_calculation_id !== 3) {
                    if (harga != 0) {
                        if (harga < min_charge) {
                            harga = min_charge;
                        }
                    }
                }

                ctrl.input.total.harga = harga;
            }

            ctrl.input.total.harga += total_price_document;
        }

        ctrl.senderCostCalculate = (idx) => {

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
                    ctrl.senderTotalResults = result.data.count;
                    ctrl.detail.senderList = result.data.senderList;
                    return result.data.senderList;
                });
        };
        ctrl.getSenderDetail = (idx) => {
            if (!ctrl.senders[idx].sender_id) {
                return;
            }

            ctrl.senders[idx].detail = ctrl.detail.senderList.find(i => i.sender_id === ctrl.senders[idx].sender_id);
            console.log(ctrl.senders[idx].detail);
            ctrl.senderItemCalculateAll()
        }

        function bapbIsValid(data) {

            if (!data.recipient_id) {
                swangular.alert("Penerima wajib diisi");
                return false;
            }

            if (!data.full_container) {
                for (let i of data.senders) {
                    if (!i.sender_id) {
                        console.log(i)
                        swangular.alert("Nama pengirim wajib diisi");
                        return false;
                    }
                }
            } else {
                for (let i of data.full_container_data.items) {
                    if (!i.sender_id) {
                        console.log(i)
                        swangular.alert("Nama pengirim wajib diisi");
                        return false;
                    }
                }
            }

            return true;
        }

        ctrl.onSubmit = () => {
            let data = ctrl.input;
            data.senders = ctrl.senders;

            data.langsung_tagih = (data.langsung_tagih === true || data.langsung_tagih === "true");

            if (data.full_container) {
                data.full_container_data = ctrl.fullContainer;
                data.senders = [];
                data.full_container_data.items.forEach(i => {
                    delete i.sender_detail;
                })
            }

            if (!bapbIsValid(data)) {
                return;
            }

            $scope.isSaving = true;

            BapbService.store(data)
                .then(res => {
                    if (res.status == 'OK') {

                        const bapb_id = res.data.bapb_id;

                        swangular.confirm('Print BAPB ?', {
                            showCancelButton: true,
                            confirmButtonText: 'Print',
                            cancelButtonText: 'Tidak',
                            preConfirm: () => {
                                console.log(data);

                            },
                        }).then(status => {

                            if (status.value) {
                                swangular.confirm('LOGO?', {
                                    showCancelButton: true,
                                    confirmButtonText: 'SR',
                                    cancelButtonText: 'SRSM',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#3085d6',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false
                                }).then((res1) => {

                                    const tipe = res1.value ? 'sr' : 'srsm';
                                    const win = window.open(`${window.location.href.split('/').slice(0, 3).join('/')}/api/bapb/generate/${bapb_id}?tipe=${tipe}&token=${$localStorage.currentUser.access_token}`, '_blank');
                                    win.focus();

                                    if (!ctrl.id) {
                                        $state.reload();
                                    } else {
                                        $state.go('admin.bapb');
                                    }
                                });
                            } else {
                                if (!ctrl.id) {
                                    $state.reload();
                                } else {
                                    $state.go('admin.bapb');
                                }
                            }
                        });
                    } else {

                        $scope.isSaving = false;
                        swangular.alert("Error, terjadi kesalahan ketika memproses bapb");
                    }
                })
                .catch(err => {
                    $scope.isSaving = false;
                    console.log(err);
                    swangular.alert("Error");
                });
        }
    }
})();
