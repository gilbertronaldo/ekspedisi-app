<data ng-init="vm = breakoutController" one-time-if="authCan('BREAKOUT_NAVIGATION_SIDEBAR')">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Breakout</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a ui-sref="admin.home">Master</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Breakout</li>
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

                        </div>
                        <div class="table-responsive">
                            <table datatable="" dt-options="vm.dtOptions" dt-columns="vm.dtColumns"
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
