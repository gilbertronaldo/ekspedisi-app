<data ng-controller="UserController">
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
                            <li class="breadcrumb-item active" aria-current="page">User</li>
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
                                    ui-sref="admin.user">
                                TAMBAH USER
                            </button>
                            {{--<button type="button" class="btn waves-effect waves-light btn-primary" ng-click="vm.exportToExcel()">--}}
                            {{--EXPORT EXCEL--}}
                            {{--</button>--}}
                        </div>
                        <div class="table-responsive">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</data>
