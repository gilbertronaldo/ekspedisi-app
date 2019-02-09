<data ng-init="ctrl = editSenderController" one-time-if="authCan('SENDER_EDIT')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Pengirim</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.home">Master</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.sender">Pengirim</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Pengirim</li>
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
                    <div class="card-body">
                        <form class="m-t-30">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kode Pengirim</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Kode Pengirim" ng-model="ctrl.input.sender_code" required>
                                <small class="form-text text-muted"></small>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengirim</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Pengirim" ng-model="ctrl.input.sender_name" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengirim di BAPB</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Pengirim di BAPB"
                                       ng-model="ctrl.input.sender_name_bapb">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengirim Lainnya</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Pengirim Lainnya"
                                       ng-model="ctrl.input.sender_name_other">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Email"
                                       ng-model="ctrl.input.email">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>Nomor Pengirim</label>
                                </div>
                                <div class="col-md-12 ml-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Handphone</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                   placeholder="Masukkan Nomor Handphone Pengirim"
                                                   ng-model="ctrl.input.sender_phone" required>
                                            <small class="form-text text-muted"></small>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Telepon</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                   placeholder="Masukkan Nomor Telephone Pengirim"
                                                   ng-model="ctrl.input.sender_telephone" required>
                                            <small class="form-text text-muted"></small>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Fax</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                   placeholder="Masukkan Nomor Fax Penerima"
                                                   ng-model="ctrl.input.sender_fax" required>
                                            <small class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Pilih Kota Pengirim</label>
                                <select class="form-control custom-select" data-placeholder="Pilih kota"
                                        tabindex="1"
                                        ng-options="item.city_id as item.city_name for item in ctrl.cityList"
                                        ng-model="ctrl.input.city_id"
                                        ng-change="ctrl.changeCity()">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Alamat Pengirim</label>
                                <textarea class="form-control" rows="5" ng-model="ctrl.input.sender_address"
                                          placeholder="Masukkan Alamat Pengirim"></textarea>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>Harga</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">per meter kubik</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" ng-model="ctrl.input.price_meter" class="form-control"
                                               aria-label="Amount (to the nearest dollar)" ui-currency>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">per ton</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" ng-model="ctrl.input.price_ton" class="form-control"
                                               aria-label="Amount (to the nearest dollar)" ui-currency>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="control-label">Minimum Charge</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                        </div>
                                        <select class="custom-select col-sm-3" id="inputGroupSelect01"
                                                ng-model="ctrl.input.minimum_charge_calculation_id"
                                                ng-options="item.calculation_id as item.calculation_name for item in ctrl.minimumChargeCalculationList">
                                            <option value="">Pilih Perhitungan</option>
                                        </select>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                               placeholder="Masukkan Minimum Charge"
                                               ng-model="ctrl.input.minimum_charge" ui-currency>
                                    </div>
                                    <small class="form-text text-muted"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Biaya Dokument</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Rp.</label>
                                        </div>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                               placeholder="Masukkan Biaya Dokument"
                                               ng-model="ctrl.input.price_document" ui-currency>
                                    </div>
                                    <small class="form-text text-muted"></small>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label">Ambil di</label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-sm-3"
                                                ng-model="ctrl.input.ambil_di">
                                            <option value="">Ambil di</option>
                                            <option value="port">Port</option>
                                            <option value="door">Door</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark" ui-sref="admin.sender">Batal</button>
                            <button type="submit" class="btn btn-primary" ng-click="ctrl.saveSender()">Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</data>
