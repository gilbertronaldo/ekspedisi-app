<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin: 150px 25px 250px;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0;
            right: 0;
            height: 150px;

            /** Extra personal styles **/
            /*background-color: darkgrey;*/
            text-align: center;
            line-height: 16px;
        }

        footer {
            position: fixed;
            bottom: -240px;
            left: 0;
            right: 0;
            height: 150px;
        }

        main {
            width: 100%;
            margin: 10px 0 -80px;
            /*background-color: pink;*/
        }

        .table-bordered {
            width: 100%;
            /*border: 1px solid black;*/
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-bordered tr th {
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #000000;
            padding: 7px;
            text-align: center;
        }

        .table-bordered tr td {
            border: 1px solid #000000;
            margin: 0;
            padding: 2px 5px;
            font-weight: normal;
            font-size: 14px;
        }

        .table-bordered-body {
            width: 100%;
            /*border: 1px solid black;*/
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-bordered-body tr th {
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #000000;
            padding: 7px;
            text-align: center;
        }

        .table-bordered-body-td {
            border: 1px solid #000000;
            margin: 0;
            padding: 2px 5px;
            font-weight: normal;
            font-size: 14px;
        }

        .d-ib {
            display: inline-block;
        }

        .t-b {
            font-weight: bold;
        }

        .t-small {
            font-size: 0.8em;
        }

        .text-center {
            text-align: center;
        }

        main.page_break + main.page_break {
            page-break-before: always;
        }

    </style>
</head>
<body>

@include('invoice.pdf.header')
@include('invoice.pdf.footer')

<main class="page_break">
    <div>

    </div>
</main>

</body>
</html>
