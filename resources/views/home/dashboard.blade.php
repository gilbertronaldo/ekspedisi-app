<data ng-init="vm = homeController">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
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
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <div class="card-group">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10 mr-2">
                                    <span class="btn btn-circle btn-lg btn-info">
                                        <i class="ti-user text-white"></i>
                                    </span>
                        </div>
                        <div>
                            Total Staff

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light" ng-bind-html="vm.header.total.staff"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10 mr-2">
                                    <span class="btn btn-circle btn-lg bg-danger">
                                        <i class="ti-clipboard text-white"></i>
                                    </span>
                        </div>
                        <div>
                            New BAPB
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light" ng-bind-html="vm.header.total.bapb"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10 mr-2">
                                    <span class="btn btn-circle btn-lg bg-success">
                                        <i class="ti-shopping-cart text-white"></i>
                                    </span>
                        </div>
                        <div>
                            Total Invoice

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light" ng-bind-html="vm.header.total.invoice"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10 mr-2">
                                    <span class="btn btn-circle btn-lg bg-warning">
                                        {{--<i class="mdi mdi-currency-usd text-white"></i>--}}
                                        <span class="text-white">Rp</span>
                                    </span>
                        </div>
                        <div>
                            Profit

                        </div>
                        <div class="ml-auto">
                            <h4 class="m-b-0 font-light">
                                {{'{{'. 'vm.header.total.profit | currency:"":0' .'}'.'}'}}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Column -->


        </div>
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title">Pengiriman Cabang</h4>
                                <h5 class="card-subtitle">Overview of Latest Month</h5>
                            </div>
                            <div class="ml-auto">
                                <ul class="list-inline font-12 dl m-r-10">
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-info"></i> BJM
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-danger"></i> SMD
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-success"></i> BPP
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-secondary"></i> MKS
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="product-sales" style="height:305px"></div>
                    </div>
                </div>

            </div>
            <!-- Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body bg-light-info">
                        <div class="d-flex align-items-center m-t-10 m-b-20">
                            <div class="m-r-10 mr-4">
                                <i class="icon-Cloud-Sun display-5"></i>
                            </div>
                            <div>
                                <h1 class="m-b-0 font-light">35
                                    <sup>o</sup>
                                </h1>
                                <h5 class="font-light">Clear and sunny</h5>
                            </div>
                        </div>
                        <div id="ct-weather" style="height: 170px"></div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div>
                                        <span class="btn-circle btn-lg btn btn-outline-secondary">
                                            <i class="wi wi-day-sunny"></i>
                                        </span>
                            </div>
                            <div class="m-l-10 ml-2">
                                <h4 class="m-b-0">Monday</h4>
                                <h6 class="font-light m-b-0">March 2019</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body bg-light-warning text-white">
                        <div id="weeksales-bar" class="position-relative" style="height: 270px"></div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div>
                                        <span class="btn-circle btn-lg btn btn-outline-secondary">
                                            <i class="ti-shopping-cart"></i>
                                        </span>
                            </div>
                            <div class="m-l-10 ml-2">
                                <h4 class="m-b-0">Invoice</h4>
                                <h6 class="font-light m-b-0">February 2019</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</data>

<link href="../../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
<link href="../../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
<link href="../../assets/libs/morris.js/morris.css" rel="stylesheet">
{{--<link href="../../dist/css/style.min.css" rel="stylesheet">--}}

{{--<script defer src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>--}}
{{--<script defer src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}
{{--<script defer src="../../assets/libs/jquery/dist/jquery.min.js"></script>--}}
{{--<script defer src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>--}}
{{--<script defer src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>--}}
{{--<script defer src="../../dist/js/app.min.js"></script>--}}
{{--<script defer src="../../dist/js/app.init.js"></script>--}}
{{--<script defer src="../../dist/js/app-style-switcher.js"></script>--}}
{{--<script defer src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>--}}
{{--<script defer src="../../assets/extra-libs/sparkline/sparkline.js"></script>--}}
{{--<script defer src="../../dist/js/waves.js"></script>--}}
{{--<script defer src="../../dist/js/sidebarmenu.js"></script>--}}
{{--<script defer src="../../dist/js/custom.min.js"></script>--}}
<script defer src="../../assets/libs/chartist/dist/chartist.min.js"></script>
<script defer src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script defer src="../../assets/extra-libs/c3/d3.min.js"></script>
<script defer src="../../assets/extra-libs/c3/c3.min.js"></script>
<script defer src="../../assets/libs/raphael/raphael.min.js"></script>
<script defer src="../../assets/libs/morris.js/morris.min.js"></script>
{{--<script defer src="../../dist/js/pages/dashboards/dashboard1.js"></script>--}}
