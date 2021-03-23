<data ng-init="vm = pajakController" one-time-if="authCan('PAJAK_NAVIGATION_SIDEBAR')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">PPN & PPH23</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="home">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pajak</li>
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
                            <h4 class="card-title m-t-10 p-b-20">Tambah Periode Pajak</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Mulai</label>
                                        <div class="col-sm-9">
                                            <input class="form-control"
                                                   ng-model="vm.input.date_start"
                                                   required
                                                   ng-model-options="{ updateOn: 'blur' }"
                                                   placeholder="Select a date..."
                                                   format="DD-MM-YYYY"
                                                   moment-picker="vm.input.date_start">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Selesai</label>
                                        <div class="col-sm-9">
                                            <input class="form-control"
                                                   ng-model="vm.input.date_end"
                                                   ng-model-options="{ updateOn: 'blur' }"
                                                   placeholder="Select a date..."
                                                   required
                                                   format="DD-MM-YYYY"
                                                   min-date="vm.input.date_start"
                                                   moment-picker="vm.input.date_end">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">PPN (%)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control"
                                                   type="number"
                                                   required
                                                   step="0.1"
                                                   ng-model="vm.input.ppn">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">PPH23 (%)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control"
                                                   type="number"
                                                   required
                                                   step="0.1"
                                                   ng-model="vm.input.pph_23">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            ng-if="vm.canEdit"
                                            ng-click="vm.onSubmit()" ng-disabled="vm.isSaving"><i ng-if="vm.isSaving"
                                                                                                  class='fa fa-spinner fa-spin '></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title m-t-10 p-b-20 text-center">PPN</h4>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>Tgl Mulai</th>
                                            <th>Tgl Selesai</th>
                                            <th>PPN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in vm.pajakPpn">
                                            <td>{{'{{'. 'item.date_start' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'item.date_end' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'item.ppn' .'}'.'}'}} %</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="card-title m-t-10 p-b-20 text-center">PPH23</h4>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>Tgl Mulai</th>
                                            <th>Tgl Selesai</th>
                                            <th>PPH 23</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in vm.pajakPph23">
                                            <td>{{'{{'. 'item.date_start' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'item.date_end' .'}'.'}'}}</td>
                                            <td>{{'{{'. 'item.pph_23' .'}'.'}'}} %</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</data>

