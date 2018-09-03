<data ng-init="vm = shipController">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Ship</h4>
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
                        <li class="breadcrumb-item active" aria-current="page">Kapal</li>
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
                        <button type="button" class="btn waves-effect waves-light btn-primary" ui-sref="admin.ship-add">
                            TAMBAH KAPAL
                        </button>
                        <button type="button" class="btn waves-effect waves-light btn-primary" ng-click="vm.exportToExcel()">
                            EXPORT EXCEL
                        </button>
                    </div>
                    <table datatable="" dt-options="vm.dtOptions" dt-columns="vm.dtColumns"
                           dt-instance="vm.dtInstance" class="row-border hover" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</data>
