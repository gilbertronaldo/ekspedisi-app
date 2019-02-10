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
                                                    <tr ng-repeat="container in vm.containerList">
                                                        <td class="text-center"
                                                            style="vertical-align: middle">{{'{{'. 'container.no_container' .'}'.'}'}}</td>
                                                        <td class="text-center" style="font-size: 1.5em;">
                                                            <div>
                                                                <input type="checkbox" id="fruit1" name="fruit-1"
                                                                       value="Apple" ng-model="container.checked"
                                                                       ng-change="vm.onCheckedContainer()">
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
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>No Bapb</th>
                                                <th>Penerima</th>
                                                <th>Koli</th>
                                                <th>Total</th>
                                                <th>Tanggal</th>
                                                <th>Action</th>
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
                                                ng-style="{ 'cursor' : (bapb.is_paid && !bapb.is_input) ? 'auto' : 'pointer' }" ng-click="vm.onInputPayment($index)">
                                                <td>
                                                    <span>
                                                        {{'{{'. 'bapb.bapb_no' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{'{{'. 'bapb.recipient_name_bapb' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{'{{'. 'bapb.koli' .'}'.'}'}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div ng-if="!bapb.is_input">
                                                        <span>Rp. 100000</span>
                                                    </div>
                                                    <div ng-if="bapb.is_input" class="form-group">
                                                        <label>
                                                            <input type="text" class="form-control" placeholder="Input Payment total">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div ng-if="!bapb.is_input">
                                                        <span>13 Agustus 2019</span>
                                                    </div>
                                                    <div ng-if="bapb.is_input" class="form-group">
                                                        <label>
                                                            <input type="text" class="form-control" placeholder="Input Payment date">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div ng-if="!bapb.is_input">
                                                        <button class="btn btn-warning">EDIT</button>
                                                    </div>
                                                    <div ng-if="bapb.is_input">
                                                        <button class="btn btn-primary" ng-click="vm.onSavePayment($index)">SAVE</button>
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
