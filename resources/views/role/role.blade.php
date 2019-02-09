<data ng-controller="RoleController">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Roles</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Roles</li>
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
                        <div class="button-group">
                            <button type="button" class="btn waves-effect waves-light btn-primary"
                                    ui-sref="admin.role-edit">
                                TAMBAH ROLE
                            </button>
                            {{--<button type="button" class="btn waves-effect waves-light btn-primary" ng-click="vm.exportToExcel()">--}}
                            {{--EXPORT EXCEL--}}
                            {{--</button>--}}
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="50%">Name</th>
                                    <th width="50%" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="role in roleList">
                                    <td>
                                        <span ng-bind-html="role.role_name"></span>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-warning btn-xs" one-time-if="authCan('ROLE_EDIT')"
                                                    ui-sref="admin.role-edit({id: role.role_id})">EDIT
                                            </button>
                                            <button class="btn btn-danger btn-xs" one-time-if="authCan('ROLE_DELETE')"
                                                    ng-click="delete(role.role_id)">
                                                DELETE
                                            </button>
                                            <button class="btn btn-primary btn-xs"
                                                    one-time-if="authCan('ROLE_MANAGE_TASKS')"
                                                    ui-sref="admin.role-task({id: role.role_id})">MANAGE TASKS
                                            </button>
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

</data>
