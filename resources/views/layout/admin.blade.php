<div id="main-wrapper" data-layout='vertical'>
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
