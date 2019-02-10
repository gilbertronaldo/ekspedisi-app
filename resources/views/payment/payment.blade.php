<data ng-init="vm = paymentController" one-time-if="authCan('PAYMENT_NAVIGATION_SIDEBAR')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Payment</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="home">Transaction</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Payment</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="form-horizontal r-separator">
                        <div class="card-body bg-light">
                            <h4 class="card-title m-t-10 p-b-20">Detail Kapal</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row border-bottom-0">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Cari</label>
                                        <div class="col-sm-9">
                                            <sc-select
                                                    id="approver-1"
                                                    ng-model="vm.input.ship_id"
                                                    sc-options="ship.ship_id as ship.no_voyage + ' - ' + ship.ship_name for ship in vm.searchShipList(searchText, page)"
                                                    page-limit="vm.shipAsyncPageLimit"
                                                    total-items="vm.shipTotalResults"
                                                    ng-change="vm.getShipDetail()"
                                                    placeholder="Cari Nomor Voyage Kapal">
                                            </sc-select>
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Ship
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.ship_name"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">No
                                            Voyage</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.no_voyage"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Tujuan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="{{  '{{'. 'vm.detail.ship.city_code_from' .'}'.'}' . ' - ' .'{{'. 'vm.detail.ship.city_code_to' .'}'.'}' }}"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Berangkat</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.sailing_date"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 border-left">
                                    <div class="form-group row">
                                        <div class="col-12 text-right">
                                            <h5 class="m-t-10 p-b-20">Container</h5>
                                            <hr>
                                        </div>
                                        <div class="col-12" ng-if="!vm.input.ship_id">
                                            <span class="text-warning"><i class="mdi mdi-alert-circle"></i>&nbsp;Pilih Kapal !</span>
                                        </div>
                                        <div class="col-12" ng-if="vm.loading[0]">
                                            <span class="text-warning">
                                                <span><i class='fa fa-spinner fa-spin'></i> </span>
                                                Loading
                                            </span>
                                        </div>
                                        <div class="col-12" ng-if="vm.input.ship_id && !vm.loading[0]">
                                            <div class="table-responsive" style="max-height: 15em">
                                                <table class="table table-striped table-hover">
                                                    <thead class="bg-dark text-white">
                                                    <tr>
                                                        <th width="50%" class="text-center">No Container</th>
                                                        <th width="50%" class="text-center">Check</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="table-hover">
                                                    <tr ng-if="vm.containerList.length == 0">
                                                        <td colspan="2">
                                                            <span class="text-warning"><i
                                                                        class="mdi mdi-alert-circle"></i>&nbsp;Tidak ada container !</span>
                                                        </td>
                                                    </tr>
                                                    <tr ng-repeat="container in vm.containerList" style="cursor:pointer;">
                                                        <td class="text-center"  ng-click="vm.onClickContainer($index)"
                                                            style="vertical-align: middle">{{'{{'. 'container.no_container' .'}'.'}'}}</td>
                                                        <td class="text-center" style="font-size: 1.5em;">
                                                            <div>
                                                                <input type="checkbox" id="fruit1" name="fruit-1"
                                                                       value="true" ng-model="container.checked" ng-change="vm.onCheckedContainer()">
                                                                <label for="fruit1"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" ng-if="vm.checkedContainer.length !== 0">
                            <h4 class="card-title m-t-10 p-b-20">Bapb List</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12" ng-if="vm.loading[1]">
                                    <span class="text-warning">
                                        <span><i class='fa fa-spinner fa-spin'></i> </span>
                                        Loading
                                    </span>
                                </div>
                                <div class="col-sm-12 col-lg-12" ng-if="!vm.loading[1]">
                                    <div class="table-responsive" style="max-height: 20em">
                                        <table class="table table-bordered table-hover text-center">
                                            <thead>
                                            <tr>
                                                <th width="10%">No Bapb</th>
                                                <th width="30%">Penerima</th>
                                                <th width="5%">Koli</th>
                                                <th width="20%">Total</th>
                                                <th width="15%">Tanggal</th>
                                                <th width="20" one-time-if="authCan('PAYMENT_INPUT')">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-if="vm.bapbList.length == 0">
                                                <td colspan="5">
                                                     <span class="text-warning"><i
                                                                 class="mdi mdi-alert-circle"></i>&nbsp;Tidak ada data !</span>
                                                </td>
                                            </tr>
                                            <tr ng-repeat="bapb in vm.bapbList"
                                                ng-style="{ 'cursor' : (!bapb.is_paid && !bapb.is_input && authCan('PAYMENT_INPUT')) ? 'pointer' : 'auto' }">
                                                <td ng-click="vm.onInputPayment($index)" class="align-middle">
                                                    <span>
                                                        {{'{{'. 'bapb.bapb_no' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td ng-click="vm.onInputPayment($index)" class="text-left align-middle">
                                                    <span>
                                                        {{'{{'. 'bapb.recipient_name_bapb' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td ng-click="vm.onInputPayment($index)" class="align-middle">
                                                    <span>
                                                        {{'{{'. 'bapb.koli' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td ng-click="vm.onInputPayment($index)" class="align-middle">
                                                    <div ng-if="!bapb.is_input">
                                                        <span ng-if="bapb.payment_total != null">
                                                            {{'{{'. 'bapb.payment_total | currency:"Rp. ":0' .'}'.'}'}}
                                                        </span>
                                                        <span ng-if="bapb.payment_total == null">
                                                            -
                                                        </span>
                                                    </div>
                                                    <div ng-if="bapb.is_input" class="form-group p-0 m-0">
                                                        <label>
                                                            <input type="text" class="form-control" ui-currency
                                                                   placeholder="Input Payment total"
                                                                   ng-model="bapb.payment_total">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td ng-click="vm.onInputPayment($index)" class="align-middle">
                                                    <div ng-if="!bapb.is_input">
                                                        <span ng-if="bapb.payment_date != null">
                                                              {{'{{'. 'bapb.payment_date_' .'}'.'}'}}
                                                        </span>
                                                        <span ng-if="bapb.payment_date == null">
                                                              -
                                                        </span>
                                                    </div>
                                                    <div ng-if="bapb.is_input" class="form-group p-0 m-0">
                                                        <label>
                                                            <input class="form-control"
                                                                   ng-model="bapb.payment_date"
                                                                   ng-model-options="{ updateOn: 'blur' }"
                                                                   placeholder="Select a date..."
                                                                   format="DD-MM-YYYY"
                                                                   moment-picker="bapb.payment_date">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle" one-time-if="authCan('PAYMENT_INPUT')">
                                                    <div ng-if="!bapb.is_input" ng-click="vm.onInputPayment($index)">
                                                        <button class="btn btn-warning">EDIT</button>
                                                    </div>
                                                    <div ng-if="bapb.is_input" class="d-inline">
                                                        <button class="btn btn-sm btn-secondary" ng-click="vm.onCancelPayment()">
                                                            CANCEL
                                                        </button>
                                                        <button class="btn btn-sm btn-primary"
                                                                ng-click="vm.onSavePayment($index)">SAVE
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</data>
