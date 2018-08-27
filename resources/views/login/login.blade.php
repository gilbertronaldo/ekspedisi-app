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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ URL::asset('dist/css/style.min.css') }}">
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

<!-- ============================================================== -->
<!-- Login box.scss -->
<!-- ============================================================== -->
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
     style="background:url(../../assets/images/big/auth-bg.jpg) no-repeat center center;">
    <div class="auth-box">
        <div id="loginform">
            <div class="logo">
                <h3 class="font-medium m-b-20">Ekspedisi</h3>
            </div>
            <!-- Form -->
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal m-t-20" id="loginform" action="{{URL::to('doLogin')}}" method="post">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" name="username" class="form-control form-control-lg"
                                   placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg"
                                   placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

</body>
</html>
