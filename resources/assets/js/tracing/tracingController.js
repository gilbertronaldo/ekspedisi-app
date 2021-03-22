;(() => {
    'use strict';

    angular
        .module('Ekspedisi.tracing')
        .controller('TracingController', TracingController);

    TracingController.$inject = [
        '$state',
        '$scope',
        'swangular',
        '$q',
        'DTOptionsBuilder',
        'DTColumnBuilder',
        '$localStorage',
        '$compile',
        'ShipService',
        '$rootScope',
        '$timeout',
        '$http',
        'TracingService',
        'RecipientService',
        '$window'
    ];

    function TracingController(
        $state,
        $scope,
        swangular,
        $q,
        DTOptionsBuilder,
        DTColumnBuilder,
        $localStorage,
        $compile,
        ShipService,
        $rootScope,
        $timeout,
        $http,
        TracingService,
        RecipientService,
        $window
    ) {

        let ctrl = this;
        ctrl.input = {};
        ctrl.code = 1;
        ctrl.detail = {};

        ctrl.tracing = {};
        $scope.attachmentsPreview = [];
        $scope.attachments = [];

        ctrl.recipientAsyncPageLimit = 20;
        ctrl.recipientTotalResults = 0;

        ctrl.checkedContainer = []
        ctrl.containerList = [];

        ctrl.loading = [
            false,
            false
        ];
        ctrl.isSaving = false;

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
            ctrl.detail.recipient = ctrl.detail.recipientList.find(i => i.recipient_id === ctrl.input.recipient_id);

            searchContainer();
        };

        function searchContainer() {
            ctrl.loading[0] = true;
            ctrl.checkedContainer = [];
            ctrl.containerList = [];
            ShipService.searchContainer({
                recipient_id: ctrl.input.recipient_id
            })
                .then(function (result) {
                    ctrl.loading[0] = false;
                    ctrl.containerList = result.data.containerList;
                })
                .catch(err => {
                    ctrl.loading[0] = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })
        }

        ctrl.onClickContainer = idx => {
            ctrl.containerList.forEach((value, index) => {
                if (index !== idx) {
                    value.checked = false;
                }
            })
            ctrl.containerList[idx].checked = !ctrl.containerList[idx].checked;
            if (ctrl.containerList[idx].checked) {
                ctrl.tracing.container = ctrl.containerList[idx];
            }
            ctrl.checkedContainer = ctrl.containerList.filter(i => i.checked);


            getTracing();
        };

        ctrl.onCheckedContainer = (idx) => {
            ctrl.containerList.forEach((value, index) => {
                if (index !== idx) {
                    value.checked = false;
                }
            })
            // ctrl.containerList[idx].checked = !ctrl.containerList[idx].checked;
            if (ctrl.containerList[idx].checked) {
                ctrl.tracing.container = ctrl.containerList[idx];
            }
            ctrl.checkedContainer = ctrl.containerList.filter(i => i.checked);

            getTracing();
        };

        function getTracing() {
            if (ctrl.checkedContainer.length === 0) {
                return;
            }

            ctrl.loading[1] = true;
            ctrl.tracing = {};
            ctrl.tracing.recipient_id = ctrl.input.recipient_id;
            ctrl.tracing.no_container_1 = ctrl.checkedContainer[0].no_container_1;
            ctrl.tracing.no_container_2 = ctrl.checkedContainer[0].no_container_2;
            ctrl.tracing.attachments_deleted = [];
            $scope.attachmentsPreview = [];
            $scope.attachments = [];

            TracingService.detail({
                recipient_id: ctrl.tracing.recipient_id,
                no_container_1: ctrl.tracing.no_container_1,
                no_container_2: ctrl.tracing.no_container_2
            })
                .then(function (result) {
                    ctrl.loading[1] = false;
                    if (result.data.tracing) {
                        ctrl.tracing = result.data.tracing;

                        if (ctrl.tracing.tanggal_terima) {
                            ctrl.tracing.tanggal_terima = moment(ctrl.tracing.tanggal_terima);
                        }

                        ctrl.tracing.attachments.forEach(i => {
                            $scope.attachmentsPreview.push(i.url);
                        })
                        ctrl.tracing.attachments_deleted = [];
                    }
                })
                .catch(err => {
                    ctrl.loading[1] = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })

        }

        $scope.fileSelected = function (element) {
            const files = element.files;

            const reader = new FileReader();

            function readFile(index) {
                if (index >= files.length) return;
                const file = files[index];
                reader.onload = function (e) {
                    // get file content
                    const bin = e.target.result;
                    $scope.imageIsLoaded(file, bin);
                    // do sth with bin
                    readFile(index + 1)
                }
                reader.readAsDataURL(file);
            }

            readFile(0);

            console.log($scope.attachments);
        };

        ctrl.removeAttachment = idx => {
            const deleted = ctrl.tracing.attachments.findIndex(i => i.url === $scope.attachmentsPreview[idx]);
            $scope.attachmentsPreview.splice(idx, 1);
            $scope.attachments.splice(idx, 1);

            if (deleted >= 0) {
                ctrl.tracing.attachments_deleted.push(ctrl.tracing.attachments[deleted]);
                ctrl.tracing.attachments.splice(deleted, 1);
            }
        }

        $scope.imageIsLoaded = function (file, bin) {
            $scope.$apply(function () {
                $scope.attachmentsPreview.push(bin);
                $scope.attachments.push(file);
            });
        }

        ctrl.onSubmit = () => {
            ctrl.isSaving = true;
            console.log(ctrl.tracing, $scope.attachments);

            const data = JSON.parse(JSON.stringify(ctrl.tracing));
            data.attachments = JSON.stringify(data.attachments);
            data.attachments_deleted = JSON.stringify(data.attachments_deleted);

            console.log(data);
            const formData = new $window.FormData();
            for (var key in data) {
                formData.append(key, data[key]);
            }
            $scope.attachments.forEach(file => {
                formData.append("files[]", file);
            })

            TracingService.save(formData)
                .then(function (result) {
                    ctrl.isSaving = false;
                    getTracing();
                })
                .catch(err => {
                    ctrl.isSaving = false;
                    console.log(err);
                    swangular.alert("Error Container List");
                })
        }

    }
})();
