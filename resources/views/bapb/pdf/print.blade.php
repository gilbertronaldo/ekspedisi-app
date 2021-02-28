<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BAPB</title>
    <style>
        @page {
            size: 21.5cm 30cm;
            margin: 230px 45px 250px;
        }

        header {
            position: fixed;
            top: -180px;
            left: 0;
            right: 0;
            height: 0px;

            /** Extra personal styles **/
            /*background-color: darkgrey;*/
            text-align: center;
            line-height: 16px;
        }

        footer {
            position: fixed;
            bottom: -150px;
            left: 0;
            right: 0;
            height: 150px;
        }

        main {
            width: 100%;
            margin: 77px 0 0;
            /*padding-left: 10px;*/
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

{{--@include('bapb.pdf.header')--}}

<main class="page_break">
    <div style="margin-top: -77px;">
        <div style="width: 100%;font-size: 16px;margin: -20px 5px 5px;text-align: left">
            <span>No.</span>&nbsp;<span class="t-b">{{ $bapb->bapb_no }}</span>
        </div>
        <table class="table-bordered">
            <tr>
                <td>
                    PENERIMA
                    <span class="d-ib" style="width: 3px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_name_bapb }}</span>
                </td>
                <td>
                    NO. VOY
                    <span class="d-ib" style="width: 64.2px;"></span>:
                    <span class="t-b">{{ $bapb->ship->no_voyage }}</span>
                </td>
            </tr>
            <tr>
                <td rowspan="3" valign="middle">ALAMAT
                    <span class="d-ib" style="width: 14.5px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_address }}</span>
                </td>
                <td>NAMA KAPAL
                    <span class="d-ib" style="width: 29px;"></span>:
                    <span class="t-b">{{ $bapb->ship->ship_name }}</span>
                </td>
            </tr>
            <tr>
                <td>TGL. BERANGKAT
                    <span class="d-ib" style="width: 1.3px;"></span>:
                    <span class="t-b">{{ \Carbon\Carbon::parse($bapb->ship->sailing_date)->format('d F Y') }}</span>
                </td>
            </tr>
            <tr>
                <td>NO. CONTAINER
                    <span class="d-ib" style="width: 13px;"></span>:
                    <span class="t-b">{{ $bapb->no_container_1 . "" . $bapb->no_container_2 }}</span>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <div style="margin-top: 10px">
            <table class="table-bordered-body" style="table-layout: fixed">
                <tr>
                    <th width="20%">PENGIRIM</th>
                    <th width="43%">JENIS BARANG</th>
                    <th width="7%">KOLI</th>
                    <th width="15%">M<sup>3</sup>/TON</th>
                    <th width="15%">BIAYA</th>
                </tr>
                @foreach($bapb->senders as $senderIdx => $sender)
                    @foreach($sender->items as $itemIdx => $item)
                        <tr>
                            <td class="table-bordered-body-td" valign="middle"
                                width="20%">
                                {{ $sender->sender->sender_name_bapb }}
                                <br>
                            </td>
                            <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;"
                                width="43%">
                                <span>{{ $item->bapb_sender_item_name }}</span>
                                @if($bapb->show_calculation)
                                    <br>
                                    @if(!is_null($item->berat))
                                        <span style="font-size: 0.9em">
                                                    ({!! number_format(($item->berat / 1000), 3, ",", ".") . '<span class="t-small"> ton</span>' !!}) (<span
                                                class="t-small">Rp. </span>{!! number_format($item->price_ton, 0, ".", ".") !!} / <span
                                                class="t-small">ton</span>)
                                                </span>
                                    @else
                                        <span style="font-size: 0.9em">
                                                    ({!! $item->panjang . '<span class="t-small">cm</span> * ' . $item->lebar .  '<span class="t-small">cm</span> * ' . $item->tinggi  . '<span class="t-small">cm</span>'!!} =  {{ number_format(($item->panjang * $item->lebar * $item->tinggi / 1000000 * $item->koli), 3, ",", ".") }} <span
                                                class="t-small">m<sup>3</sup></span>)
                                                    (<span class="t-small">Rp. </span>{!! number_format($item->price_meter, 0, ".", ".") !!} / <span
                                                class="t-small">m<sup>3</sup></span>)
                                                </span>
                                    @endif
                                @endif
                            </td>
                            <td class="table-bordered-body-td text-center" style="margin: 0;padding: 2px 5px;"
                                valign="middle"
                                width="7%">
                                {{ $item->koli }}
                            </td>
                            <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;"
                                width="15%">
                                @if($bapb->show_calculation)
                                    @if(!is_null($item->berat))
                                        <span>
                                                    <span
                                                        style="color: white;"></span>
                                                    {{ number_format(($item->berat * $item->koli / 1000), 3, ",", ".") }}
                                                </span>
                                        <span> Ton</span>
                                    @else
                                        <span>
                                                    <span
                                                        style="color: white;"></span>
                                                    {{ number_format(($item->panjang * $item->lebar * $item->tinggi / 1000000 * $item->koli), 3, ",", ".") }}
                                                </span>
                                        <span> M<sup>3</sup></span>
                                    @endif
                                @endif
                                @if(!$bapb->show_calculation && $bapb->squeeze)
                                    @if(!is_null($item->berat))
                                        <span>
                                                    <span
                                                        style="color: white;"></span>
                                                    {{ number_format(($item->berat / 1000), 3, ",", ".") }}
                                                </span>
                                        <span> Ton</span>
                                    @else
                                        <span>
                                                    <span
                                                        style="color: white;"></span>
                                                    {{ number_format(($item->dimensi / 1000000), 3, ",", ".") }}
                                                </span>
                                        <span> M<sup>3</sup></span>
                                    @endif
                                @endif
                            </td>
                            <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;"
                                width="15%">
                                @if($bapb->show_price && !$bapb->kena_min_charge)
                                    <span>Rp.<span
                                            style="color: white;"></span>{{ number_format($item->price, 0, ".", ".") }}</span>
                                @endif
                            </td>
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="2" style="text-align: right">
                        Sub Total&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td class="table-bordered-body-td text-center">
                        {{ $bapb->koli }}
                    </td>
                    <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;">
                            <span>
                                <span
                                    style="color: white;"></span>
                                {{ number_format($bapb->berat, 3, ",", ".") }}
                            </span>
                        <span> Ton</span>
                        <br>
                        <span>
                            <span
                                style="color: white;"></span>
                            {{ number_format($bapb->dimensi, 3, ",", ".") }}
                        </span>
                        <span> M<sup>3</sup></span>
                    </td>
                    <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;">
                        @if ($bapb->show_price)
                            <span>Rp. <span
                                    style="color: white;"></span>{{ number_format(($bapb->harga) - $bapb->total_price_document, 0, ".", ".") }}</span>
                        @endif
                    </td>
                </tr>
                @foreach($bapb->senders as $senderIdx => $sender)
                    @foreach($sender->costs as $cost)
                        @if(!is_null($cost->price))
                            <tr>
                                <td class="table-bordered-body-td" valign="middle"
                                    width="20%">
                                    {{ $sender->sender->sender_name_bapb }}
                                    <br>
                                    {{--                            <span style="font-size: 11px">({{ $sender->sender->sender_address }})</span>--}}
                                </td>
                                <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;"
                                    colspan="3">{{ $cost->bapb_sender_cost_name }}</td>
                                <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;">
                                    @if ($bapb->show_price)
                                        <span>Rp. <span
                                                style="color: white;"></span>{{ number_format($cost->price, 0, ".", ".") }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="3">
                        @if($bapb->kena_min_charge || $bapb->show_price)
                            @if($bapb->recipient->minimum_charge_calculation_id != 1 && $bapb->recipient->minimum_charge_calculation_id != 3)
                                @if($bapb->tagih_di == 'recipient')
                                    <span style="font-weight: normal;font-size: 14px;">
                                        Minimal Charge =
                                        Rp. {{ number_format($bapb->recipient->minimum_charge, 0, ".", ".") }}
                                    </span>
                                @endif
                                @if($bapb->tagih_di != 'recipient')
                                    <span style="font-weight: normal;font-size: 14px;">
                                        Minimal Charge =
                                        Rp. {{ number_format($bapb->senders[0]->minimum_charge, 0, ".", ".") }}
                                    </span>
                                @endif
                            @else
                                @if($bapb->tagih_di == 'recipient')
                                    <span style="font-weight: normal;font-size: 14px;">

                                        Minimal Charge
                                        = {{ number_format($bapb->recipient->minimum_charge / 1000, 3, ",", ".") }}
                                        ton/m3
                                </span>
                                @endif
                                @if($bapb->tagih_di != 'recipient')
                                    <span style="font-weight: normal;font-size: 14px;">

                                        Minimal Charge
                                        = {{ number_format($bapb->senders[0]->minimum_charge / 1000, 3, ",", ".") }}
                                        ton/m3
                                </span>
                                @endif
                            @endif

                            @if($bapb->show_price)
                                @if($bapb->berat != 0)
                                    <br>
                                    <span style="font-weight: normal;font-size: 14px;">
                                    Harga =
                                    <span
                                        class="t-small">Rp. </span>{!! number_format($item->price_ton, 0, ".", ".") !!} / <span
                                            class="t-small">ton</span>
                                </span>
                                @endif
                                @if($bapb->dimensi != 0)
                                    <br>
                                    <span style="font-weight: normal;font-size: 14px;">
                                    Harga =
                                    <span class="t-small">Rp. </span>{!! number_format($item->price_meter, 0, ".", ".") !!} / <span
                                            class="t-small">m<sup>3</sup></span>
                                </span>
                                @endif
                            @endif
                        @endif
                    </td>
                    <td style="text-align: right">
                        <span>Dokumen&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </td>
                    <td class="table-bordered-body-td">
                        @if ($bapb->show_price)
                            @if($bapb->tagih_di == 'recipient')
                                <span>
                                Rp.<span
                                        style="color: white;"></span>{{ number_format($bapb->total_price_document, 0, ".", ".") }}
                                </span>
                            @endif
                            @if( $bapb->tagih_di != 'recipient')
                                <span>
                                Rp.<span
                                        style="color: white;"></span>{{ number_format($bapb->senders[0]->price_document, 0, ".", ".") }}
                                </span>
                            @endif
                        @endif
                    </td>
                </tr>
                <tr style="border-left: none">
                    <td colspan="3" rowspan="7" valign="top"
                        style="border: none;text-transform: uppercase;">
                        @if ($bapb->show_price)
                            <span style="font-weight: normal;font-size: 14px;">TERBILANG ( {{ $bapb->terbilang }} RUPIAH )</span>
                        @endif
                    </td>
                    <td style="text-align: right">
                        <span>Total&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </td>
                    <td class="table-bordered-body-td" style="margin: 0;padding: 2px 5px;">
                        @if ($bapb->show_price)
                            @if($bapb->tagih_di == 'recipient')
                                <span>Rp. <span
                                        style="color: white;"></span>{{ number_format($bapb->harga + $bapb->cost, 0, ".", ".") }}</span>
                            @endif
                            @if($bapb->tagih_di != 'recipient')
                                <span>Rp. <span
                                        style="color: white;"></span>{{ number_format(($bapb->harga + $bapb->cost) - $bapb->total_price_document, 0, ".", ".") }}</span>
                            @endif
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</main>


</body>
</html>
