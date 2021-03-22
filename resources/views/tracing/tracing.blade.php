<data ng-init="vm = tracingController" one-time-if="authCan('TRACING_NAVIGATION_SIDEBAR')">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Tracing</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Tracing</li>
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
                                    <div class="form-group row border-bottom-0">
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
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Kode
                                            Penerima</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.recipient.recipient_code"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Nama
                                            Penerima</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.recipient.recipient_name"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Nama Penerima
                                            BAPB</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   ng-model="vm.detail.recipient.recipient_name_bapb"
                                                   placeholder="" ng-disabled="true">
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom-0">
                                        <label
                                            class="col-sm-3 text-right control-label col-form-label">Kota</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="{{  '{{'. 'vm.detail.recipient.city_code' .'}'.'}' . ' - ' .'{{'. 'vm.detail.recipient.city_name' .'}'.'}' }}"
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
                                        <div class="col-12" ng-if="!vm.input.recipient_id">
                                            <span class="text-warning"><i class="mdi mdi-alert-circle"></i>&nbsp;Pilih Penerima !</span>
                                        </div>
                                        <div class="col-12" ng-if="vm.loading[0]">
                                            <span class="text-warning">
                                                <span><i class='fa fa-spinner fa-spin'></i> </span>
                                                Loading
                                            </span>
                                        </div>
                                        <div class="col-12" ng-if="vm.input.recipient_id && !vm.loading[0]">
                                            <div class="table-responsive" style="max-height: 15em">
                                                <table class="table table-hover">
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
                                                    <tr ng-repeat="container in vm.containerList"
                                                        style="cursor:pointer;">
                                                        <td class="text-center" ng-click="vm.onClickContainer($index)"
                                                            style="vertical-align: middle">{{'{{'. 'container.no_container' .'}'.'}'}}</td>
                                                        <td class="text-center" style="font-size: 1.5em;">
                                                            <div>
                                                                <input type="checkbox"
                                                                       id="fruit-{{'{{'. '$index' .'}'.'}'}}"
                                                                       name="fruit-{{'{{'. '$index' .'}'.'}'}}"
                                                                       value="true" ng-model="container.checked"
                                                                       ng-change="vm.onCheckedContainer($index)">
                                                                <label for="fruit-{{'{{'. '$index' .'}'.'}'}}"></label>
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
                            <h4 class="card-title m-t-10 p-b-20">Data Tracing</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12" ng-if="vm.loading[1]">
                                    <span class="text-warning">
                                        <span><i class='fa fa-spinner fa-spin'></i> </span>
                                        Loading
                                    </span>
                                </div>
                                <div class="col-sm-12 col-lg-12" ng-if="!vm.loading[1]">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="input-penerima">Container</label>
                                                <input type="text" class="form-control" id="input-penerima"
                                                       value="{{  '{{'. 'vm.tracing.no_container_1' .'}'.'}' . ' ' .'{{'. 'vm.tracing.no_container_2' .'}'.'}' }}"
                                                      disabled
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-penerima">Penerima</label>
                                                <input type="text" class="form-control" id="input-penerima"
                                                       placeholder="Nama Penerima" ng-model="vm.tracing.name"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-date">Tanggal Terima</label>
                                                <input type="text" class="form-control" id="input-date"
                                                       placeholder="Tanggal terima"
                                                       ng-model="vm.tracing.tanggal_terima"
                                                       ng-model-options="{ updateOn: 'blur' }"
                                                       format="DD-MM-YYYY HH:mm"
                                                       moment-picker="vm.tracing.tanggal_terima"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-koli">Koli</label>
                                                <input type="number" class="form-control" id="input-koli"
                                                       placeholder="Total koli" ng-model="vm.tracing.koli"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-keterangan">Keterangan</label>
                                                <textarea type="text" class="form-control"
                                                          ng-model="vm.tracing.description"
                                                          placeholder="Masukkan keterangan" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="input-file">Foto</label>
                                                <input type="file" class="form-control" id="input-file"
                                                       multiple accept="image/*"
                                                       onchange="angular.element(this).scope().fileSelected(this)">
                                                {{--                                                <button ng-click="vm.addFile()">Add</button>--}}
                                            </div>
                                            <div class="row">
                                                <div class="col-12 image-preview" ng-repeat="file in attachmentsPreview track by $index">
                                                    <button type="button" class="btn btn-warning btn-sm" ng-click="vm.removeAttachment($index)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                    <img ng-src="{{  '{{'. 'file' .'}'.'}' }}" width="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                    ng-click="vm.onSubmit()" ng-disabled="vm.isSaving"><i ng-if="vm.isSaving"
                                                                                                       class='fa fa-spinner fa-spin '></i>Simpan
                                            </button>
                                        </div>
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


<style>
    .image-preview {
        padding: 1rem;
        background-color: #e9ecef;
        margin-bottom: 1rem;
    }
    .image-preview img{
        width: 100%;
    }
    .image-preview button {
        position: absolute;
        right: 0;
        top: 0rem;
        border-radius: 50%;
        box-shadow: 0 1px 5px rgba(61, 61, 61, 0.5);
    }
</style>
