<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SRSM</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logo-light-icon.png"/>

    {{--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>--}}
    {{--<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'/>--}}
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/select.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/sc-select.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/angular-moment-picker/angular-moment-picker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

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
    <script src="{{ URL::asset('js/html5shiv.js') }}"></script>
    <script src="{{ URL::asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body ng-app="Ekspedisi.app" dir="ltr">

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
</body>
</html>
