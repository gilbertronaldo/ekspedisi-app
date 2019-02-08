<!-- ============================================================== -->
<!-- Login box.scss -->
<!-- ============================================================== -->
<data ng-init="ctrl = loginController">
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url(../../assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo mb-3">
                    <h3 class="font-medium m-b-20">Ekspedisi</h3>
                    <h4 class="font-medium m-b-20">PT. SUMBER REJEKI SINAR MANDIRI</h4>
                </div>
                <!-- Form -->
                <div class="row mt-5">
                    <div class="col-12">
                        <form class="form-horizontal m-t-20" id="loginform">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                                class="mdi mdi-account"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control form-control-lg"
                                       ng-disabled="ctrl.loading"
                                       placeholder="Username" aria-label="Email" aria-describedby="basic-addon1"
                                       ng-model="ctrl.input.email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i
                                                class="mdi mdi-barcode"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control form-control-lg"
                                       ng-disabled="ctrl.loading"
                                       placeholder="Password" aria-label="Password" aria-describedby="basic-addon1"
                                       ng-model="ctrl.input.password">
                            </div>
                            <div class="form-group text-center mt-5">
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-info" ng-click="ctrl.doLogin()"
                                            ng-disabled="ctrl.loading">
                                        <span ng-if="ctrl.loading"><i class='fa fa-spinner fa-spin'></i> </span>Log In
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
</data>
