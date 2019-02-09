<data ng-init="ctrl = addShipController" one-time-if="authCan('SHIP_ADD')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Kapal</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Master</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Kapal</li>
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
                                <label for="exampleInputEmail1">No Voyage</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nomor Voyage" ng-model="ctrl.input.no_voyage" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kapal</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       placeholder="Masukkan Nama Kapal" ng-model="ctrl.input.ship_name" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tanggal Keberangkatan</label>
                                {{--<input type="date" class="form-control" uib-datepicker-popup="<% format %>"--}}
                                       {{--ng-model="ctrl.input.sailing_date"--}}
                                       {{--is-open="ctrl.periodDatePickerOpened[0]"--}}
                                       {{--close-text="Close"--}}
                                       {{--ng-click="ctrl.openPeriodDatePicker($event,0)">--}}

                                <input class="form-control"
                                       ng-model="ctrl.input.sailing_date"
                                       ng-model-options="{ updateOn: 'blur' }"
                                       placeholder="Select a date..."
                                       format="DD-MM-YYYY"
                                       moment-picker="ctrl.input.sailing_date">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="control-label">Tujuan</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control custom-select" data-placeholder="Choose a Category"
                                                tabindex="1"
                                                ng-options="item.city_id as item.city_code + ' - ' + item.city_name for item in ctrl.cityList"
                                                ng-model="ctrl.input.city_id_from"
                                                ng-change="ctrl.changeCity()" required>
                                            <option value="">Dari</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control custom-select" data-placeholder="Choose a Category"
                                                tabindex="1"
                                                ng-options="item.city_id as item.city_code + ' - ' + item.city_name for item in ctrl.cityList"
                                                ng-model="ctrl.input.city_id_to"
                                                ng-change="ctrl.changeCity()" required>
                                            <option value="">Menuju</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deskripsi</label>
                                <textarea class="form-control" rows="5" ng-model="ctrl.input.ship_description"
                                          placeholder="Masukkan Deskripsi Kapal"></textarea>
                                <small class="form-text text-muted"></small>
                            </div>
                            <button type="button" class="btn btn-dark" ui-sref="admin.ship">Batal</button>
                            <button type="submit" class="btn btn-primary" ng-click="ctrl.saveShip()">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</data>
