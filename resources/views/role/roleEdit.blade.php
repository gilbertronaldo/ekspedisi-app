<data ng-controller="EditRoleController" one-time-if="authCan('ROLE_EDIT, ROLE_ADD')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title" ng-bind-html="editMode ? 'Edit Role' : 'New Role'"></h4>
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
                            <li class="breadcrumb-item active" aria-current="page"
                                ng-bind-html="editMode ? 'Edit' : 'New'"></li>
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
                                <label for="input-name">Role Name</label>
                                <input type="text" class="form-control" aria-describedby="input-name" id="input-name"
                                       placeholder="Masukkan Nama Role" ng-model="input.role_name">
                                <small class="form-text text-muted"></small>
                            </div>
                            <button type="button" class="btn btn-dark" ui-sref="admin.role">Batal</button>
                            <button type="submit" class="btn btn-primary" ng-click="save()">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</data>
