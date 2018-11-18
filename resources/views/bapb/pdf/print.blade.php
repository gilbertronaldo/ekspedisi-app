<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 0 25px;
        }

        header {
            position: fixed;
            top: 10px;
            left: 0px;
            right: 0px;
            height: 80px;

            /** Extra personal styles **/
            /*background-color: darkgrey;*/
            text-align: center;
            line-height: 16px;
        }

        main {
            margin: 110px 0;
            height: 750px;
            width: 100%;
            background-color: pink;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            height: 150px;

            /** Extra personal styles **/
            background-color: #03a9f4;
            /*color: white;*/
            /*text-align: center;*/
            /*line-height: 1px;*/
        }
    </style>
</head>
<body>
<header>
    <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
    <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
    <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
    <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta Utara</h5>
    <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
</header>
<!-- Wrap the content of your PDF inside a main tag -->
<main>
    <div style="text-align: center;width: 100%;">
        <h4>BERITA ACARA PENYERAHAN BARANG</h4>
    </div>
    <div>
        <table border="1" style="width: 100%; table-layout: fixed">
            <tr>
                <td>PENGIRIM:</td>
                <td>NO. VOY:</td>
            </tr>
            <tr>
                <td>ALAMAT :</td>
                <td>PENERIMA :</td>
            </tr>
            <tr>
                <td>NAMA KAPAL:</td>
                <td>ALAMAT:</td>
            </tr>
            <tr>
                <td>TGL. BERANGKAT:</td>
                <td></td>
            </tr>
        </table>
    </div>
    <br>
    <div>
        <table border="1" style="width: 100%">
            <tr>
                <th>BANYAK KOLI</th>
                <th>JENIS BARANG</th>
                <th>M<sup>3</sup>/TON</th>
                <th>JUMLAH SEWA</th>
            </tr>
            <tr>

            </tr>
        </table>
    </div>
</main>
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
</body>
</html>
