<data ng-init="vm = bapbController" one-time-if="authCan('BAPB_NAVIGATION_SIDEBAR')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Bapb</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.bapb">Bapb</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bapb</li>
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
                            <button type="button" class="btn waves-effect waves-light btn-primary" one-time-if="authCan('BAPB_INPUT')"
                                    ui-sref="admin.bapb-input">
                                INPUT BAPB
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table datatable="" dt-options="vm.dtOptions" dt-columns="vm.dtColumns" id="bapb-table"
                                   dt-instance="vm.dtInstance" class="table table-bordered" width="100%"
                                   cellspacing="0">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</data>
