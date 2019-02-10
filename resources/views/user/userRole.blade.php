<data ng-controller="RoleUserController" one-time-if="authCan('USER_MANAGE_ROLES')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">User Roles</h4>
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
                                <a ui-sref="admin.user">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Role</li>
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
                        <form class="m-t-30">
                            <div class="form-group">
                                <label for="input-name">Nama</label>
                                <input type="text" class="form-control" aria-describedby="input-name" id="input-name"
                                       placeholder="Masukkan Nama" ng-model="input.name" ng-disabled="true">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="input-username">Username</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp" id="input-username"
                                       placeholder="Masukkan Username" ng-model="input.email" ng-disabled="true">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-12">
                                    <label>Roles</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <caption class="text-right">
                                                <a style="padding: 0.5em"
                                                   class="btn btn-circle btn-outline-warning btn-sm text-dark"
                                                   ng-click="onPopUserRole()">
                                                    <i class="mdi mdi-minus"></i>
                                                </a>
                                                <a style="padding: 0.5em"
                                                   class="btn btn-circle btn-outline-info btn-sm text-dark"
                                                   ng-click="onPushUserRole()"><i
                                                            class="mdi mdi-plus"></i></a>
                                            </caption>
                                            <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="40%">Role</th>
                                                <th width="55%">Location</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="userRole in userRoles">
                                                <td style="vertical-align: middle; text-align: center">
                                                    <span>1</span>
                                                </td>
                                                <td>
                                                    <div class="form-group m-0 p-0">
                                                        <select class="form-control"
                                                                name="input-select-role"
                                                                id="input-select-role"
                                                                ng-options="item.role_id as item.role_name for item in roles"
                                                                ng-model="userRole.role_id">
                                                            <option value="">Select Role</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group m-0 p-0">
                                                        <select class="form-control"
                                                                name="input-select-role"
                                                                id="input-select-role"
                                                                ng-options="item.city_code as item.name for item in locations"
                                                                ng-model="userRole.city_code">
                                                            <option value="">Select Office</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-dark" ui-sref="admin.user">Batal</button>
                            <button type="submit" class="btn btn-primary" ng-click="save()">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</data>
