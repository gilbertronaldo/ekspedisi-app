<data ng-controller="EditUserController" one-time-if="authCan('USER_EDIT, USER_ADD')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title" ng-bind-html="editMode ? 'Edit User' : 'New User'"></h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                                       placeholder="Masukkan Nama" ng-model="input.name">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="input-username">Username</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp" id="input-username"
                                       placeholder="Masukkan Username" ng-model="input.email">
                                <small class="form-text text-muted"></small>
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
