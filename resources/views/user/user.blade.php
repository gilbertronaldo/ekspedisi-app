<data ng-controller="UserController" one-time-if="authCan('USER_NAVIGATION_SIDEBAR')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Users</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                                    one-time-if="authCan('USER_ADD')"
                                    ui-sref="admin.user-edit">
                                TAMBAH USER
                            </button>
                            {{--<button type="button" class="btn waves-effect waves-light btn-primary" ng-click="vm.exportToExcel()">--}}
                            {{--EXPORT EXCEL--}}
                            {{--</button>--}}
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="30%">Name</th>
                                    <th width="30%">Username</th>
                                    <th width="40%" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="user in userList">
                                    <td>
                                        <span ng-bind-html="user.name"></span>
                                    </td>
                                    <td>
                                        <span ng-bind-html="user.email"></span>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-warning btn-xs" one-time-if="authCan('USER_EDIT')"
                                                    ui-sref="admin.user-edit({id: user.id})">EDIT
                                            </button>
                                            <button class="btn btn-danger btn-xs" one-time-if="authCan('USER_DELETE')"
                                                    ng-click="deleteUser(user.id)">
                                                DELETE
                                            </button>
                                            <button class="btn btn-primary btn-xs"
                                                    one-time-if="authCan('USER_MANAGE_ROLES')"
                                                    ui-sref="admin.user-role({id: user.id})">MANAGE ROLES
                                            </button>
                                            <button class="btn btn-warning btn-xs"
                                                    one-time-if="authCan('USER_CHANGE_PASSWORD')"
                                                    ng-click="changePassword(user.id)">CHANGE PASSWORD
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
