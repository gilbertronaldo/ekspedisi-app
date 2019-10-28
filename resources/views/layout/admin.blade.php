<div id="main-wrapper" data-layout='vertical' ng-controller="LayoutController">
    <div ng-if="loading[0]">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <ng-template ng-hide="loading[0]">


        <header class="topbar">
            @include('layout.header')
        </header>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
            @include('layout.navigation')
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
                All Rights Reserved by <a href="https://gilbert.id">PLATO</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
    </ng-template>
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
