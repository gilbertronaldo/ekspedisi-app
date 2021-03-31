<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @page {
            size: 21.5cm 30cm;
            margin: 150px 45px 250px;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0;
            right: 0;
            height: 150px;

            /** Extra personal styles **/
            /*background-color: darkgrey;*/
            text-align: left;
            line-height: 16px;
        }

        footer {
            position: fixed;
            bottom: -200px;
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

@include('ship.pdf.header')
{{--@include('invoice.pdf.footer')--}}

<main class="page_break">
    <div>
        <span>Kepada Yth,</span>
        <br><span>{{ $recipient->recipient_name_bapb }}</span>
        <br><span>{{ $recipient->recipient_address }}</span>
        <br><span>TEL&nbsp;&nbsp;: {{ $recipient->recipient_telephone }}</span>
        <br><span>FAX&nbsp;: {{ $recipient->recipient_fax }}</span>
    </div>
    <div style="margin-top: 10px;">
        <span>Dengan Hormat,</span>
        <br>
        <span>Bersama ini surat ini menginformasikan keberangkatan kapal sebagai berikut : </span>
    </div>

    <table style="margin: 10px;padding: 10px; width: 50%;">
        <tr>
            <td>Nama Kapal</td>
            <td>{{ $ship->ship_name }}</td>
        </tr>
        <tr>
            <td>Tanggal Berangkat</td>
            <td>{{ \Carbon\Carbon::parse($ship->sailing_date)->format('d F Y') }}</td>
        </tr>
    </table>

    <table class="table-bordered-body" style="width: 100%;">
        <tr>
            <th>No. Container</th>
            <th>Pengirim</th>
{{--            <th>Nama Barang</th>--}}
            <th>Jumlah</th>
        </tr>
        @foreach($items as $item)
            <tr>
                <td class="table-bordered-body-td text-center">{{ $item->no_container_1 . ' ' . $item->no_container_2 }}</td>
                <td class="table-bordered-body-td">{{ $item->sender_name_bapb  }}</td>
{{--                <td class="table-bordered-body-td">{{ $item->bapb_sender_item_name }}</td>--}}
                <td class="table-bordered-body-td text-center">{{ $item->koli }} Koli</td>
            </tr>
        @endforeach
    </table>

    <p>Untuk perwakilan di {{ $contact['city_full'] }} dapat menghubungi {{ $contact['name'] }} ({{ $contact['phone'] }}) mengenai pengiriman barang ke tempat saudara
        dengan menyebutkan nama kapal dan no. container. Terima Kasih</p>

</main>

</body>
</html>
