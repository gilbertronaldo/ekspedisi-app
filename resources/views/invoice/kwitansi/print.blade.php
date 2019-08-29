<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kwitansi</title>
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

        .table-bordered-body tr td {
            /*padding: 10px 0;*/
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

@include('invoice.kwitansi.header')
{{--@include('invoice.pdf.footer')--}}

<main class="page_break">
    <hr>
    <div style="margin-top: 10px">
        <table class="table-bordered-body" style="table-layout: fixed;width: 100%">
            <tr>
                <td width="25%" class="table-bordered-body-td">
                    <span style="text-decoration: underline">Sudah terima dari</span>
                    <br>
                    <span style="font-style: italic;font-size: 0.8em">Recieved from</span>
                </td>
                <td width="75%" class="table-bordered-body-td">
                    {{--<span>:&nbsp;</span>--}}
                    <span style="font-weight: bold">
                        {{ $recipient->recipient_name_bapb }}
                    </span>
                </td>
            </tr>
            <tr>
                <td width="25%" class="table-bordered-body-td">
                    <span style="text-decoration: underline">Banyaknya uang</span>
                    <br>
                    <span style="font-style: italic;font-size: 0.8em">Amount</span>
                </td>
                <td width="75%" class="table-bordered-body-td">
                    {{--<span>:&nbsp;</span>--}}
                    <span style="text-transform: uppercase;font-weight: bold">
                        {{ $terbilang }} RUPIAH.
                    </span>
                </td>
            </tr>
            <tr>
                <td width="25%" class="table-bordered-body-td">
                    <span style="text-decoration: underline">Untuk pembayaran</span>
                    <br>
                    <span style="font-style: italic;font-size: 0.8em">For payment of</span>
                </td>
                <td width="75%" class="table-bordered-body-td">
                    {{--<span>:&nbsp;</span>--}}
                    <span style="font-weight: bold">
                        Biaya Ekspedisi JKT - {{ $recipient->city->city_code }}
                    </span>
                </td>
            </tr>
            {{--<tr>--}}
            {{--<td style="text-align: center;margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;">--}}
            {{--Yang harus dibayar--}}
            {{--</td>--}}
            {{--<td style="margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;border: 1px solid black">--}}
            {{--<span>Rp. <span--}}
            {{--style="color: white;">{{ substr(str_pad(number_format($total, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($total, 0, ".", "."))) }}</span>{{ number_format($total, 0, ".", ".") }}</span>--}}
            {{--</td>--}}
            {{--</tr>--}}
        </table>
    </div>
    <div style="width: 100%;margin-top: 20px;">
        <table style="text-align: center !important;width: 100%">
            <tr style="">
                <td style="text-align: center">
                    {{--Yang Menerima--}}
                </td>
                <td style=" text-align: center">
                    Jakarta, {{  \Carbon\Carbon::now()->format('d F Y') }}
                </td>
            </tr>
            <tr>
                <td>=================================</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <span style="font-style: italic">Jumlah/Amount</span>
                    <span>&nbsp;:&nbsp;<span style="font-weight: bold">Rp. <span
                                    style="color: white;">{{ substr(str_pad(number_format($total, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($total, 0, ".", "."))) }}</span>{{ number_format($total, 0, ".", ".") }}</span></span>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>=================================</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="">
                <td style="">
                    {{--__________________--}}
                </td>
                <td style="font-size: 13px;">
                    (SUMBER REJEKI)
                </td>
            </tr>
        </table>
    </div>
</main>

</body>
</html>
