<data ng-init="vm = inputBapbController">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Input Berita Acara Penerimaan barang</h4>
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
                                <a ui-sref="bapb.view">Bapb</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Input Bapb</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label for="bapb-no"
                                               class="col-sm-3 text-right control-label col-form-label">
                                            CODE
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="custom-select col-sm-6" id="inputGroupSelect01"
                                                    ng-init="vm.code = 1"
                                                    ng-model="vm.code" ng-change="vm.changeCode()"
                                                    ng-options="code.code_id as code.name for code in vm.codeList">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label for="bapb-no"
                                               class="col-sm-3 text-right control-label col-form-label">
                                            No BAPB
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="bapb-no"
                                                   placeholder="Input Nomor BAPB" ng-model="vm.input.bapb_no"
                                                   ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">

                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label for="tagih-di"
                                               class="col-sm-3 text-right control-label col-form-label">
                                            Tagih di
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="custom-select col-sm-5" id="inputGroupSelect01"
                                                    ng-model="vm.input.tagih_di"
                                                    ng-change="vm.changeCalculation()">
                                                <option value="">Tagih di</option>
                                                <option value="recipient">Penerima</option>
                                                <option value="sender">Pengirim</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">

                                </div>
                            </div>
                        </div>

                        <div class="card-body bg-light">
                            <h4 class="card-title m-t-10 p-b-20">Detail Kapal</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
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
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">No
                                            Voyage</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.no_voyage"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row p-t-15">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Tujuan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="{{  '{{'. 'vm.detail.ship.city_code_from' .'}'.'}' . ' - ' .'{{'. 'vm.detail.ship.city_code_to' .'}'.'}' }}"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Ship
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.ship_name"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row p-t-15">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">Berangkat</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.ship.sailing_date"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">No.
                                            Container</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.input.no_container_1"
                                                   placeholder="Kode">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control"
                                                   ng-model="vm.input.no_container_2"
                                                   placeholder="Nomor">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row p-t-15">
                                        <label
                                                class="col-sm-3 text-right control-label col-form-label">No.
                                            Segel</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.input.no_seal"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                        <div class="card-body bg-light">
                            <h4 class="card-title m-t-10 p-b-20">Detail Pengirim</h4>
                            <div class="pl-5 pt-3" ng-repeat="sender in vm.senders" ng-init="senderIdx = $index">
                                <h6 class="card-title m-t-10 p-b-20">Pengirim {{'{{'. 'senderIdx + 1' .'}'.'}'}}</h6>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row">
                                            <label
                                                    class="col-sm-3 text-right control-label col-form-label">Cari</label>
                                            <div class="col-sm-9">
                                                <sc-select
                                                        id="approver-1"
                                                        ng-model="sender.sender_id"
                                                        sc-options="_sender.sender_id as _sender.sender_code + ' - ' + _sender.sender_name for _sender in vm.searchSenderList(searchText, page)"
                                                        page-limit="vm.senderAsyncPageLimit"
                                                        total-items="vm.senderTotalResults"
                                                        ng-change="vm.getSenderDetail(senderIdx)"
                                                        placeholder="Cari Pengirim">
                                                </sc-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row">
                                            <label
                                                    class="col-sm-3 text-right control-label col-form-label">Nama di
                                                BAPB
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       ng-model="sender.detail.sender_name_bapb"
                                                       placeholder="" ng-disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row p-t-15">
                                            <label
                                                    class="col-sm-3 text-right control-label col-form-label">Kemasan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       ng-model="sender.kemasan"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row p-t-15">
                                            <label
                                                    class="col-sm-3 text-right control-label col-form-label">Tgl.
                                                Masuk</label>
                                            <div class="col-sm-9">
                                                <input class="form-control"
                                                       ng-model="sender.entry_date"
                                                       ng-model-options="{ updateOn: 'blur' }"
                                                       placeholder="Select a date..."
                                                       format="DD-MM-YYYY"
                                                       moment-picker="sender.entry_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row p-t-15">
                                            <label
                                                    class="col-sm-3 text-right control-label col-form-label">Krani</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                       ng-model="sender.krani"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <caption class="text-right">
                                            <a class="btn btn-circle btn-outline-warning btn-sm text-dark"
                                               ng-click="vm.senderItemPop(senderIdx)">-</a>
                                            <a class="btn btn-circle btn-outline-info btn-sm text-dark"
                                               ng-click="vm.senderItemPush(senderIdx)">+</a>
                                        </caption>
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Koli</th>
                                            <th scope="col">P <span>(cm)</span></th>
                                            <th scope="col">L <span>(cm)</span></th>
                                            <th scope="col">T <span>(cm)</span></th>
                                            <th scope="col">Berat <span>(kg)</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="sItem in sender.items" ng-init="sItemIdx = $index">
                                            <th scope="row">{{'{{'. 'sItemIdx + 1' .'}'.'}'}}</th>
                                            <td>
                                                <input class="form-control form-control-sm" type="text"
                                                       ng-model="sItem.bapb_sender_item_name"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number"
                                                       ng-model="sItem.koli" min="0"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number"
                                                       ng-model="sItem.panjang" min="0"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number"
                                                       ng-model="sItem.lebar" min="0"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number"
                                                       ng-model="sItem.tinggi" min="0"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number"
                                                       ng-model="sItem.berat" min="0"
                                                       ng-change="vm.senderItemCalculate(senderIdx)">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-sm-12 text-left control-label col-form-label">Keterangan
                                                Perhitungan</label>
                                            <div class="col-md-8 offset-2">
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Harga per Meter</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'vm.input.tagih_di == "sender" ? sender.detail.price_meter : vm.detail.calculation.price_meter | currency:"Rp.":0' .'}'.'}'}}</code>&nbsp;<span></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Harga per Ton</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'vm.input.tagih_di == "sender" ? sender.detail.price_ton : vm.detail.calculation.price_ton | currency:"Rp.":0' .'}'.'}'}}</code>&nbsp;<span></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Biaya Dokumen</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'vm.input.tagih_di == "sender" ? sender.detail.price_document : vm.detail.calculation.price_document | currency:"Rp.":0' .'}'.'}'}}</code>&nbsp;<span></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Min. Charge</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'vm.input.tagih_di == "sender" ? sender.detail.minimum_charge : vm.detail.calculation.minimum_charge | currency:"Rp.":0' .'}'.'}'}}</code>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-sm-12 text-left control-label col-form-label">&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;Keterangan</label>
                                            <div class="col-md-8 offset-2">
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Total Koli</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'sender.total.koli | number:3' .'}'.'}'}}</code>&nbsp;<span>Koli</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Dimensi Total</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'sender.total.dimensi | number:3' .'}'.'}'}}</code>&nbsp;<span>m<sup>3</sup></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Berat Total</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'sender.total.berat | number:3' .'}'.'}'}}</code>&nbsp;<span>Ton</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 text-right">
                                                        <span>Total Harga</span>
                                                    </div>
                                                    <div class="col-sm-7 text-left">
                                                        <code>{{'{{'. 'sender.total.harga | currency:"Rp.":0' .'}'.'}'}}</code>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" ng-if="senderIdx == vm.senders.length - 1">
                                    <div class="col-md-12 pull-right text-right">
                                        <button class="btn btn-dark btn-circle" ng-click="vm.senderPop()">-</button>
                                        <button class="btn btn-default btn-circle" ng-click="vm.senderPush()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group row">
                                        <label
                                                class="col-sm-12 text-left control-label col-form-label">Keterangan</label>
                                        <div class="col-lg-12">
                                            <textarea type="text" class="form-control"
                                                      ng-model="vm.input.bapb_description"
                                                      placeholder="Masukkan keterangan Bapb" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <h4 class="card-title m-t-10 p-b-20">Detail Bapb</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="text-center">
                                                <th scope="col">Penerima</th>
                                                <th scope="col">Pengirim</th>
                                                <th scope="col">Total Koli</th>
                                                <th scope="col">Dimensi Total</th>
                                                <th scope="col">Berat Total</th>
                                                <th scope="col">Total harga</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="text-center" ng-repeat="sender in vm.senders"
                                                ng-init="senderIdx = $index" ng-if="sender.sender_id">
                                                <td class="align-middle"
                                                    rowspan="{{  '{{'. 'vm.senders.length' .'}'.'}' }}"
                                                    ng-if="senderIdx == 0">
                                                    <span>{{  '{{'. 'vm.detail.recipient.recipient_name_bapb' .'}'.'}' }}</span>
                                                </td>
                                                <td>
                                                    <span>{{  '{{'. 'sender.detail.sender_name_bapb' .'}'.'}' }}</span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'sender.total.koli | number:3' .'}'.'}'}}</code>&nbsp;<span>Koli</span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'sender.total.dimensi | number:3' .'}'.'}'}}</code>&nbsp;<span>m<sup>3</sup></span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'sender.total.berat | number:3' .'}'.'}'}}</code>&nbsp;<span>Ton</span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'sender.total.harga | currency:"Rp.":0' .'}'.'}'}}</code>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="2">
                                                    Total Keseluruhan
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'vm.input.total.koli | number:3' .'}'.'}'}}</code>&nbsp;<span>Koli</span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'vm.input.total.dimensi | number:3' .'}'.'}'}}</code>&nbsp;<span>m<sup>3</sup></span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'vm.input.total.berat | number:3' .'}'.'}'}}</code>&nbsp;<span>Ton</span>
                                                </td>
                                                <td>
                                                    <code>{{'{{'. 'vm.input.total.harga | currency:"Rp.":0' .'}'.'}'}}</code>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group m-b-0 text-right">
                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                        ui-sref="admin.home">Batal
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                        ng-click="vm.onSubmit()">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</data>
