<data ng-init="ctrl = editRecipientController">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Penerima</h4>
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
                                <a ui-sref="admin.recipient">Penerima</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Penerima</li>
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
                                <label for="exampleInputEmail1">Kode Penerima</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Kode Penerima" ng-model="ctrl.input.recipient_code" required>
                                <small class="form-text text-muted"></small>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Penerima</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Penerima" ng-model="ctrl.input.recipient_name" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Penerima di BAPB</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Penerima di BAPB"
                                       ng-model="ctrl.input.recipient_name_bapb">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Penerima Lainnya</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Penerima Lainnya"
                                       ng-model="ctrl.input.recipient_name_other">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Handphone Penerima</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nomor Handphone Penerima"
                                       ng-model="ctrl.input.recipient_phone">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Telepon Penerima</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nomor Telephone Penerima"
                                       ng-model="ctrl.input.recipient_telephone" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Fax Penerima</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nomor Fax Penerima"
                                       ng-model="ctrl.input.recipient_fax" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Pilih Kota Penerima</label>
                                <select class="form-control custom-select" data-placeholder="Pilih kota"
                                        tabindex="1"
                                        ng-options="item.city_id as item.city_name for item in ctrl.cityList"
                                        ng-model="ctrl.input.city_id"
                                        ng-change="ctrl.changeCity()">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Alamat Penerima</label>
                                <textarea class="form-control" rows="5" ng-model="ctrl.input.recipient_address"
                                          placeholder="Masukkan Alamat Penerima"></textarea>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>Harga</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">per ton</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" ng-model="ctrl.input.price_ton" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">per meter kubik</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" ng-model="ctrl.input.price_meter" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Minimum Charge</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Minimum Charge"
                                       ng-model="ctrl.input.minimum_charge">
                                <small class="form-text text-muted"></small>
                            </div>
                            <button type="submit" class="btn btn-dark" ui-sref="admin.recipient">Batal</button>
                            <button type="submit" class="btn btn-primary" ng-click="ctrl.saveRecipient()">Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</data>
