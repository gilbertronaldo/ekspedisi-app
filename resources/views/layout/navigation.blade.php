<nav class="sidebar-nav">
    <ul id="sidebarnav">

        <li class="sidebar-item" ui-sref-active='selected'>
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.home"
               aria-expanded="false">
                <i class="mdi mdi-home"></i>
                <span class="hide-menu">Home</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-show="authCan('SHIP_NAVIGATION_SIDEBAR, RECIPIENT_NAVIGATION_SIDEBAR, SENDER_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
               aria-expanded="false">
                <i class="mdi mdi-database"></i>
                <span class="hide-menu">Master </span>
            </a>
            <ul aria-expanded="false" class="collapse  first-level">
                <li class="sidebar-item" ng-show="authCan('SHIP_NAVIGATION_SIDEBAR')">
                    <a class="sidebar-link" ui-sref="admin.ship">
                        <i class="icon-Record"></i>
                        <span class="hide-menu">Kapal</span>
                    </a>
                </li>
                <li class="sidebar-item" ng-show="authCan('RECIPIENT_NAVIGATION_SIDEBAR')">
                    <a class="sidebar-link" ui-sref="admin.recipient">
                        <i class="icon-Record"></i>
                        <span class="hide-menu">Penerima</span>
                    </a>
                </li>
                <li class="sidebar-item" ng-show="authCan('SENDER_NAVIGATION_SIDEBAR')">
                    <a class="sidebar-link" ui-sref="admin.sender">
                        <i class="icon-Record"></i>
                        <span class="hide-menu">Pengirim</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('BAPB_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.bapb"
               aria-expanded="false">
                <i class="mdi mdi-pen"></i>
                <span class="hide-menu">Bapb</span>
            </a>
        </li>
        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('INVOICE_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.invoice"
               aria-expanded="false">
                <i class="icon-Receipt-3"></i>
                <span class="hide-menu">Invoice</span>
            </a>
        </li>
        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('PAYMENT_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.payment"
               aria-expanded="false">
                <i class="ti-money"></i>
                <span class="hide-menu">Payment</span>
            </a>
        </li>
        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('BREAKOUT_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.breakout"
               aria-expanded="false">
                <i class="icon-Receipt-2"></i>
                <span class="hide-menu">Breakout</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('TRACING_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.tracing"
               aria-expanded="false">
                <i class="mdi mdi-magnify"></i>
                <span class="hide-menu">Tracing</span>
            </a>
        </li>

{{--        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('SEARCH_NAVIGATION_SIDEBAR')">--}}
{{--            <a class="sidebar-link active waves-effect waves-dark sidebar-link"--}}
{{--               ui-sref="admin.search"--}}
{{--               aria-expanded="false">--}}
{{--                <i class="mdi mdi-magnify"></i>--}}
{{--                <span class="hide-menu">Search</span>--}}
{{--            </a>--}}
{{--        </li>--}}

        <li class="nav-small-cap" ng-if="authCan('PPN_NAVIGATION_SIDEBAR, CONTAINER_NAVIGATION_SIDEBAR')">
            <i class="mdi mdi-settings"></i>
            <span class="hide-menu">REPORTS</span>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('PPN_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link" ui-sref="admin.ppn"
               aria-expanded="false">
                <i class="icon-Receipt-3"></i>
                <span class="hide-menu">PPN</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('CONTAINER_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.container"
               aria-expanded="false">
                <i class="mdi mdi-content-paste"></i>
                <span class="hide-menu">Container</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('SHIP_DEPARTURE_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.ship-departure"
               aria-expanded="false">
                <i class="mdi mdi-content-paste"></i>
                <span class="hide-menu">Keberangkatan Kapal</span>
            </a>
        </li>

        <li class="nav-small-cap" ng-if="authCan('PAJAK_NAVIGATION_SIDEBAR, USER_NAVIGATION_SIDEBAR, ROLE_NAVIGATION_SIDEBAR')">
            <i class="mdi mdi-settings"></i>
            <span class="hide-menu">Settings</span>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('PAJAK_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.pajak"
               aria-expanded="false">
                <i class="icon-Receipt"></i>
                <span class="hide-menu">PPN & PPH23</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('USER_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.user"
               aria-expanded="false">
                <i class="icon-Add-User"></i>
                <span class="hide-menu">Users</span>
            </a>
        </li>

        <li class="sidebar-item" ui-sref-active='selected' ng-if="authCan('ROLE_NAVIGATION_SIDEBAR')">
            <a class="sidebar-link active waves-effect waves-dark sidebar-link"
               ui-sref="admin.role"
               aria-expanded="false">
                <i class="mdi mdi-account-key"></i>
                <span class="hide-menu">Roles</span>
            </a>
        </li>
    </ul>
</nav>
