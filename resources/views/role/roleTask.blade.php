<data ng-controller="TaskRoleController" one-time-if="authCan('ROLE_MANAGE_TASKS')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Manage Role Tasks</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.home">Settings</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.role">Roles</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xlg-6">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="input-name">Role Name</label>
                                <input type="text" class="form-control" aria-describedby="input-name" id="input-name"
                                       placeholder="Masukkan Nama Role" ng-model="input.role_name" ng-disabled="true">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-12">
                                    <label>Tasks</label>
                                    <div class="table-responsive" style="max-height: 25em;">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="10%" class="text-center">
                                                    <div>
                                                        <input type="checkbox" id="input-check-all"
                                                               name="input-check-all"
                                                               value="Apple" ng-model="checkedAll"
                                                               ng-change="onCheckedAll(checkedAll)">
                                                        <label for="input-check-all"></label>
                                                    </div>
                                                </th>
                                                <th width="20%">Code</th>
                                                <th width="40%">Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="task in tasks">
                                                <td class="text-center">
                                                    <div>
                                                        <input type="checkbox"
                                                               id="input-check-{{'{{'. '$index' .'}'.'}'}}"
                                                               name="input-check-{{'{{'. '$index' .'}'.'}'}}"
                                                               ng-model="task.checked" ng-change="onChecked($index)">
                                                        <label for="input-check-{{'{{'. '$index' .'}'.'}'}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span ng-bind-html="task.task_code"></span>
                                                </td>
                                                <td>
                                                    <span ng-bind-html="task.task_description"></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-dark" ui-sref="admin.role">Batal</button>
                                    <button type="submit" class="btn btn-primary" ng-click="save()">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</data>
