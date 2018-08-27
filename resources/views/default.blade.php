<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ URL::asset('dist/css/style.min.css') }}">

    <style>
        .page-wrapper .container-fluid {
            padding: 20px;
            min-height: calc(100vh - 180px);
        }

        table.dataTable > tbody > tr > td:last-child {
            display: inline-flex;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="Ekspedisi.app">

<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="ti-menu ti-close"></i>
                </a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="#/home">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="../../assets/images/logo-icon.png" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo icon -->
                        <img src="../../assets/images/logo-light-icon.png" alt="homepage" class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="../../assets/images/logo-text.png" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo text -->
                            <img src="../../assets/images/logo-light-text.png" class="light-logo" alt="homepage"/>
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
                    <i class="ti-more"></i>
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
                        <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                           data-sidebartype="mini-sidebar">
                            <i class="sl-icon-menu font-20"></i>
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
                           aria-expanded="false">
                            <img src="../../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <a class="dropdown-item" href="{{ "/doLogout" }}">
                                <i class="fa fa-power-off m-r-5 m-l-5"></i>Logout</a>
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
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" ui-sref="home"
                           aria-expanded="false">
                            <i class="mdi mdi-border-top"></i>
                            <span class="hide-menu">Home</span>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

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
<script src="../../assets/libs/chartist/dist/chartist.min.js"></script>
<script src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<!--c3 charts -->
<script src="../../assets/extra-libs/c3/d3.min.js"></script>
<script src="../../assets/extra-libs/c3/c3.min.js"></script>
<!--chartjs -->
<script src="../../assets/libs/raphael/raphael.min.js"></script>
<script src="../../assets/libs/morris.js/morris.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular-animate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular-sanitize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.20/angular-ui-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>

<script src="{{ URL::asset('src/main/app.js') }}"></script>
<script src="{{ URL::asset('src/home/home.js') }}"></script>
<script src="{{ URL::asset('src/home/homeController.js') }}"></script>
</body>
</html>
