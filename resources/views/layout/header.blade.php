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
            <img src="../img/logo-srsm.png" alt="homepage" class="dark-logo" width="50" height="50"/>
            <!-- Light Logo icon -->
                {{--<img src="../../assets/images/logo-light-icon.png" alt="homepage" class="light-logo"/>--}}
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <h3 class="logo-text font-weight-bold text-dark ml-3">
                            <!-- dark Logo text -->
                            {{--<img src="../../assets/images/logo-text.png" alt="homepage" class="dark-logo"/>--}}
            <!-- Light Logo text -->
                {{--<img src="../../assets/images/logo-light-text.png" class="light-logo" alt="homepage"/>--}}
                            S&nbsp;R&nbsp;S&nbsp;M
                        </h3>
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
                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY"
                     style="min-width: 10em !important;padding: 0;">
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
