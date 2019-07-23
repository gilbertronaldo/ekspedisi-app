<data ng-init="vm = inputInvoiceController" one-time-if="authCan('INVOICE_ADD')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Input Invoice</h4>
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
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.invoice">Invoice</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Input Invoice</li>
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
                            <h4 class="card-title m-t-10 p-b-20">Detail Penerima</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Cari</label>
                                        <div class="col-sm-9">
                                            <sc-select
                                                    id="approver-1"
                                                    ng-model="vm.input.recipient_id"
                                                    sc-options="recipient.recipient_id as recipient.recipient_code + ' - ' + recipient.recipient_name for recipient in vm.searchRecipientList(searchText, page)"
                                                    page-limit="vm.recipientAsyncPageLimit"
                                                    total-items="vm.recipientTotalResults"
                                                    ng-change="vm.getRecipientDetail()"
                                                    placeholder="Cari Penerima">
                                            </sc-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Kota
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-value="vm.detail.recipient.city.city_code + ' - ' + vm.detail.recipient.city_name"
                                                   ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Nama Penerima
                                            di
                                            BAPB
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.recipient.recipient_name_bapb"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row p-t-15">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control"
                                                      ng-model="vm.detail.recipient.recipient_address"
                                                      placeholder="" ng-disabled="true"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" ng-if="vm.input.recipient_id">
                            <h4 class="card-title m-t-10 p-b-20">List BAPB Penerima</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 table-responsive">
                                    {{--<table datatable="" dt-options="vm.dtOptions" dt-columns="vm.dtColumns"--}}
                                           {{--dt-instance="vm.dtInstance" class="table table-bordered" width="100%"--}}
                                           {{--cellspacing="0">--}}
                                    {{--</table>--}}
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>No BAPB</th>
                                            <th>No Cont</th>
                                            <th>Voyage</th>
{{--                                            <th>Tujuan</th>--}}
                                            <th>Tgl Brngkt</th>
{{--                                            <th>Pengirim</th>--}}
                                            <th>Jumlah (Rp)</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr ng-if="vm.bapbList.length == 0">
                                            <td colspan="7">Tidak ada data BAPB tersedia</td>
                                        </tr>
                                        <tr ng-repeat="bapb in vm.bapbList track by bapb.bapb_id">
                                            <td>{{'{{'. 'bapb.bapb_no' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'bapb.no_container' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'bapb.no_voyage' .'}'.'}'}}</td>
{{--                                            <td>{{'{{'. 'bapb.city_code' .'}'.'}'}}</td>--}}
                                            <td>{{'{{'. 'bapb.sailing_date' .'}'.'}'}}</td>
{{--                                            <td>{{'{{'. 'bapb.recipient_name_bapb' .'}'.'}'}}</td>--}}
                                            <td>{{'{{'. 'bapb.total' .'}'.'}'}}</td>
                                            <td>
                                                <button class="btn btn-primary btn-xs"
                                                        ng-click="vm.addBapb(bapb)">
                                                    ADD
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light" ng-if="vm.input.recipient_id">
                            <h4 class="card-title m-t-10 p-b-20">Daftar BAPB Invoice</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 table-responsive">
                                    <table class="table table-bordered table-active table-striped">
                                        <tr>
                                            <th>No BAPB</th>
                                            <th>No Cont</th>
                                            <th>Voyage</th>
{{--                                            <th>Tujuan</th>--}}
                                            <th>Tgl Brngkt</th>
{{--                                            <th>Pengirim</th>--}}
                                            <th>Jumlah (Rp)</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr ng-if="vm.newBapbList.length == 0">
                                            <td colspan="7">Pilih BAPB</td>
                                        </tr>
                                        <tr ng-repeat="bapb in vm.newBapbList track by bapb.bapb_id">
                                            <td>{{'{{'. 'bapb.bapb_no' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'bapb.no_container' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'bapb.no_voyage' .'}'.'}'}}</td>
{{--                                            <td>{{'{{'. 'bapb.city_code' .'}'.'}'}}</td>--}}
                                            <td>{{'{{'. 'bapb.sailing_date' .'}'.'}'}}</td>
{{--                                            <td>{{'{{'. 'bapb.recipient_name_bapb' .'}'.'}'}}</td>--}}
                                            <td>{{'{{'. 'bapb.total' .'}'.'}'}}</td>
                                            <td>
                                                <button class="btn btn-danger btn-xs"
                                                        ng-click="vm.removeBapb(bapb)">
                                                    REMOVE
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            {{--<div class="row mt-3">--}}
                                {{--<div class="col-sm-12 col-lg-6">--}}
                                    {{--<div class="form-group row">--}}
                                        {{--<label for="voice-no"--}}
                                               {{--class="col-sm-3 text-left control-label col-form-label">--}}
                                            {{--No invoice--}}
                                        {{--</label>--}}
                                        {{--<div class="col-sm-9">--}}
                                            {{--<input type="text" class="form-control" id="invoice-no"--}}
                                                   {{--placeholder="Input Nomor invoice" ng-model="vm.input.invoice_no"--}}
                                                   {{--ng-disabled="true">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-12 col-lg-6">--}}

                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card-body bg-light">
                            <div class="form-group m-b-0 text-right">
                                <button type="button" class="btn btn-dark waves-effect waves-light"
                                        ui-sref="admin.invoice">Batal
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                        ng-if="vm.input.recipient_id"
                                        ng-if="vm.input.recipient_id"
                                        ng-click="vm.onSubmit()">Simpan
                                </button>
                                {{--<button type="submit" class="btn btn-primary waves-effect waves-light"--}}
                                        {{--ng-if="vm.input.recipient_id"--}}
                                        {{--ng-click="vm.onSubmit()">Print & Simpan--}}
                                {{--</button>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</data>
