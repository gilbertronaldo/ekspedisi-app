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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/css/bootstrap.min.css"/>

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
<ui-view></ui-view>

<script src="{{  URL::asset('js/app.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>

<script src="{{ URL::asset('src/main/app.js') }}"></script>
<script src="{{ URL::asset('src/admin/admin.js') }}"></script>
<script src="{{ URL::asset('src/admin/adminController.js') }}"></script>
<script src="{{ URL::asset('src/home/home.js') }}"></script>
<script src="{{ URL::asset('src/home/homeController.js') }}"></script>
<script src="{{ URL::asset('src/auth/auth.js') }}"></script>
<script src="{{ URL::asset('src/auth/loginController.js') }}"></script>
<script src="{{ URL::asset('src/auth/authService.js') }}"></script>
</body>
</html>
