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
            margin: 250px 25px;
        }

        header {
            position: fixed;
            top: -250px;
            left: 0;
            right: 0;
            height: 250px;

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
            height: 100px;

            background-color: #03a9f4;
        }

        main {
            width: 100%;
            margin: 0 0 -100px;
            background-color: pink;
        }


        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table tr th {
            font-weight: bold;
            font-size: 13px;
            border: 1px solid #000000;
            padding: 7px;
            text-align: center;
        }

        table tr td {
            border: 1px solid #000000;
            margin: 0;
            padding: 2px 5px;
            font-weight: normal;
            font-size: 13px;
        }

        .d-ib {
            display: inline-block;
        }

        .t-b {
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <div style="float: left;margin-left: 50px;">
        <img src="{{ public_path('img/logo.png') }}" alt="" width="100" height="100">
    </div>
    <div>
        <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
        <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
        <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
        <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta
            Utara</h5>
        <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
    </div>
    <div style="text-align: center;width: 100%;">
        <h4>BERITA ACARA PENYERAHAN BARANG</h4>
    </div>
    <div style="width: 100%;font-size: 16px;margin: -20px 5px 5px;text-align: left">
        <span>No.</span>&nbsp;<span class="t-b">{{ $bapb->bapb_no }}</span>
    </div>
    <div>
        <table>
            <tr>
                <td>
                    PENGIRIM
                    <span class="d-ib" style="width: 49.4px;"></span>:
                    <span class="t-b"></span>
                </td>
                <td>
                    NO. VOY
                    <span class="d-ib" style="width: 15px;"></span>:
                    <span class="t-b">{{ $bapb->ship->no_voyage }}</span>
                </td>
            </tr>
            <tr>
                <td>ALAMAT
                    <span class="d-ib" style="width: 60px;"></span>:
                    <span class="t-b"></span>
                </td>
                <td>PENERIMA
                    <span class="d-ib" style="width: 5px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_name }}</span>
                </td>
            </tr>
            <tr>
                <td>NAMA KAPAL
                    <span class="d-ib" style="width: 29px;"></span>:
                    <span class="t-b">{{ $bapb->ship->ship_name }}</span>
                </td>
                <td rowspan="2" valign="top">
                    ALAMAT
                    <span class="d-ib" style="width: 16px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_address }}</span>
                </td>
            </tr>
            <tr>
                <td>TGL. BERANGKAT
                    <span class="d-ib" style="width: 3.7px;"></span>:
                    <span class="t-b">{{ \Carbon\Carbon::parse($bapb->ship->sailing_date)->format('d F Y') }}</span>
                </td>
            </tr>
        </table>
    </div>
</header>
<footer>
    <table style="width: 100%">
        <tr>
            <td width="60%" style="background-color: blue">
                <span>Perjanjian :</span>
                {{--<ol>--}}
                {{--<li>1</li>--}}
                {{--<li>2</li>--}}
                {{--<li>3</li>--}}
                {{--</ol>--}}
                {{--<span>Himbauan : </span>--}}
                {{--<ul>--}}
                {{--<li>4</li>--}}
                {{--</ul>--}}
            </td>
            <td width="40%" style="background-color: red">
                2
            </td>
        </tr>
    </table>
</footer>
<!-- Wrap the content of your PDF inside a main tag -->
<main style="page-break-before: auto;">
    <div>
        <table>
            <tr>
                <th width="10%">BANYAK KOLI</th>
                <th width="60%">JENIS BARANG</th>
                <th width="10%">M<sup>3</sup>/TON</th>
                <th width="10%">JUMLAH SEWA</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr><tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr> <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Handphone Asus</td>
                <td>10</td>
                <td>10</td>
            </tr>


        </table>
    </div>
</main>

</body>
</html>
