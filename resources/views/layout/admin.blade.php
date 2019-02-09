<div id="main-wrapper" data-layout='vertical' ng-controller="LayoutController">
    <div class="preloader" ng-show="loading[0]">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <header class="topbar" ng-hide="!loading[0]">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none">
                    <i class="mdi mdi-sort-variant" style="color: white;font-size: 2em"></i>
                </a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="#/home">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        {{--<img src="../../assets/images/logo-icon.png" alt="homepage" class="dark-logo"/>--}}
                        <!-- Light Logo icon -->
                        <img src="../../assets/images/logo-light-icon.png" alt="homepage" class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text font-weight-bold text-white ml-3">
                            <!-- dark Logo text -->
                            {{--<img src="../../assets/images/logo-text.png" alt="homepage" class="dark-logo"/>--}}
                        <!-- Light Logo text -->
                            {{--<img src="../../assets/images/logo-light-text.png" class="light-logo" alt="homepage"/>--}}
                            S&nbsp;R&nbsp;S&nbsp;M
                        </span>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-more" style="color: white;font-size: 1.5em"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link sidebartoggler waves-effect waves-light""
                           data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-sort-variant" style="font-size: 2em"></i>
                        </a>
                    </li>
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" style="display: flex">
                            <span style="margin-right: 1em;font-size: 1em" ng-bind-html="username">Admin</span>
                            {{--<img src="../../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31">--}}
                            <i class="mdi mdi-account-circle" alt="user" width="50" style="font-size: 3em"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY" style="min-width: 10em !important;padding: 0;">
                            <a class="dropdown-item" href="#" ng-click="doLogout()">
                                <i class="mdi mdi-logout" style="margin-right: 2em"></i>LOGOUT</a>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.home"
                           aria-expanded="false">
                            <i class="mdi mdi-home"></i>
                            <span class="hide-menu">Home</span>
                        </a>
                    </li>

                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="mdi mdi-database"></i>
                            <span class="hide-menu">Master </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link" ui-sref="admin.ship">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu">Kapal</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" ui-sref="admin.recipient">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu">Penerima</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" ui-sref="admin.sender">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu">Pengirim</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.bapb"
                           aria-expanded="false">
                            <i class="mdi mdi-pen"></i>
                            <span class="hide-menu">Bapb</span>
                        </a>
                    </li>
                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.invoice"
                           aria-expanded="false">
                            <i class="icon-Receipt-3"></i>
                            <span class="hide-menu">Invoice</span>
                        </a>
                    </li>
                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.payment"
                           aria-expanded="false">
                            <i class="ti-money"></i>
                            <span class="hide-menu">Payment</span>
                        </a>
                    </li>
                    <li class="sidebar-item" ui-sref-active='selected'>
                        <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.container"
                           aria-expanded="false">
                            <i class="mdi mdi-content-paste"></i>
                            <span class="hide-menu">Container</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>


    <div class="page-wrapper">
        <div class="content" ui-view></div>
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by <a href="https://gilbertronaldo.com">Gilbert Ronaldo</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
</div>



{{--apps--}}
<script src="{{ URL::asset('dist/js/app.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/app.init.js') }}"></script>
<script src="{{ URL::asset('dist/js/app-style-switcher.js') }}"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="../../dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="../../dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="../../dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!--chartis chart-->
{{--<script src="../../assets/libs/chartist/dist/chartist.min.js"></script>--}}
{{--<script src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>--}}
{{--<!--c3 charts -->--}}
{{--<script src="../../assets/extra-libs/c3/d3.min.js"></script>--}}
{{--<script src="../../assets/extra-libs/c3/c3.min.js"></script>--}}
{{--<!--chartjs -->--}}
{{--<script src="../../assets/libs/raphael/raphael.min.js"></script>--}}
{{--<script src="../../assets/libs/morris.js/morris.min.js"></script>--}}
