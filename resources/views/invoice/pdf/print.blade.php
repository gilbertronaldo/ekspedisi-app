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
        <span>Bersama ini kami kirimkan perincian tagihan sebagai berikut: </span>
    </div>
    <div style="margin-top: 10px">
        <table class="table-bordered-body" style="table-layout: fixed">
            <tr>
                <th width="5%">NO</th>
                <th width="12%">NO. BAPB</th>
                <th width="10%">NO. CONT</th>
                <th width="10%">TUJUAN</th>
                <th width="10%">TGL BRKT</th>
                <th width="38%">PENGIRIM</th>
                <th width="15%">Jumlah (Rp)</th>
            </tr>
            @foreach($bapbList as $bapbIdx => $bapb)
                <tr>
                    <td class="table-bordered-body-td text-center" valign="middle">
                        {{ $bapbIdx + 1 }}
                    </td>
                    <td class="table-bordered-body-td text-center" valign="middle">
                        {{ $bapb->bapb_no }}
                    </td>
                    <td class="table-bordered-body-td text-center" valign="middle">
                        {{ $bapb->no_container }}
                    </td>
                    <td class="table-bordered-body-td text-center" valign="middle">
                        {{ $bapb->destination }}
                    </td>
                    <td class="table-bordered-body-td text-center" valign="middle">
                        {{ $bapb->sailing_date }}
                    </td>
                    <td class="table-bordered-body-td" valign="middle">
                        {{ $bapb->senders }}
                    </td>
                    <td class="table-bordered-body-td" valign="middle">
                        <span>Rp. <span
                                style="color: white;">{{ substr(str_pad(number_format($bapb->harga, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($bapb->harga, 0, ".", "."))) }}</span>{{ number_format($bapb->harga, 0, ".", ".") }}</span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5"></td>
                <td style="text-align: center;margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;">
                    Sub Total
                </td>
                <td style="margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;border: 1px solid black">
                    <span>Rp. <span
                            style="color: white;">{{ substr(str_pad(number_format($subTotal, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($subTotal, 0, ".", "."))) }}</span>{{ number_format($subTotal, 0, ".", ".") }}</span>
                </td>
            </tr>
            @if($invoice->is_pph === true)
                <tr>
                    <td colspan="5"></td>
                    <td style="text-align: center;margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;">
                        Potongan PPH 2%
                    </td>
                    <td style="margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;border: 1px solid black">
                    <span>Rp. <span
                            style="color: white;">{{ substr(str_pad(number_format($totalPph, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($totalPph, 0, ".", "."))) }}</span>{{ number_format($totalPph, 0, ".", ".") }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="text-align: center;margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;">
                        Total setelah potongan PPH
                    </td>
                    <td style="margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;border: 1px solid black">
                    <span>Rp. <span
                            style="color: white;">{{ substr(str_pad(number_format($subTotal - $totalPph, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($subTotal - $totalPph, 0, ".", "."))) }}</span>{{ number_format($subTotal - $totalPph, 0, ".", ".") }}</span>
                    </td>
                </tr>
            @endif
            @foreach($bapbList as $bapbIdx => $bapb)
                @foreach($bapb->costs as $costIdx => $cost)
                    <tr>
                        <td class="table-bordered-body-td text-left" valign="middle" width="20%" colspan="3">
                            {{ $cost->sender }}
                        </td>
                        <td class="table-bordered-body-td text-left" valign="middle" width="20%" colspan="3">
                            {{ $cost->name }}
                        </td>
                        <td class="table-bordered-body-td" valign="middle">
                        <span>Rp. <span
                                style="color: white;">{{ substr(str_pad(number_format($cost->price, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($cost->price, 0, ".", "."))) }}</span>{{ number_format($cost->price, 0, ".", ".") }}</span>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="5"></td>
                <td style="text-align: center;margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;">
                    Yang harus dibayar
                </td>
                <td style="margin: 0;padding: 2px 5px;font-weight: normal;font-size: 14px;border: 1px solid black">
                    <span>Rp. <span
                            style="color: white;">{{ substr(str_pad(number_format($totalAll, 0, ".", "."), 12, "-", STR_PAD_LEFT), 0, 0 - strlen(number_format($totalAll, 0, ".", "."))) }}</span>{{ number_format($totalAll, 0, ".", ".") }}</span>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 10px">
        <span>Pembayaran diatas ditransfer ke rekening {{ $officeBranch->bank_account }}</span>
        <br><span>Atas nama: {{ $officeBranch->bank_account_name }}</span>
        <br><span>Acc: {{ $officeBranch->bank_account_number }}</span>
        <br><span>Bukti transfer harap mencantumkan no. Invoice dan di fax ke (021) 6240380 atau WA 0857 7595 9469</span>
        <p>Terima kasih atas kerjasamanya</p>

        <p>Diterima tgl:</p>
    </div>
    <div style="width: 100%;">
        <table style="text-align: center !important;width: 100%">
            <tr style="">
                <td style="text-align: center">
                    Yang Menerima
                </td>
                <td style=" text-align: center">
                    Hormat Kami
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="">
                <td style="">
                    __________________
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
