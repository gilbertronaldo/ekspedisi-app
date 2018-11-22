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
            top: -240px;
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
            height: 150px;
        }

        main {
            width: 100%;
            margin: 10px 0 -80px;
            /*background-color: pink;*/
        }

        .table-bordered {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-bordered tr th {
            font-weight: bold;
            font-size: 13px;
            border: 1px solid #000000;
            padding: 7px;
            text-align: center;
        }

        .table-bordered tr td {
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

@include('bapb.pdf.header')
@include('bapb.pdf.footer')

<main style="page-break-before: auto;">
    <div>
        <table class="table-bordered">
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


        </table>
    </div>
</main>

</body>
</html>
