<table>
    <tr>
        <th></th>
    </tr>
    <tr>
        <th></th>
    </tr>
    <tr>
        <th>NO. INVOICE</th>
        <th>{{ $invoice->invoice_no }}</th>
    </tr>
</table>
<table>
    <thead>
    <tr style="background-color: yellow;">
        <th>NO</th>
        <th>NO. BAPB</th>
        <th>NO. CONT</th>
        <th>TUJUAN</th>
        <th>TGL BRKT</th>
        <th>PENGIRIM</th>
        <th>Jumlah (Rp)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bapbList as $itemIdx => $item)
        <tr>
            <td>{{ $itemIdx + 1 }}</td>
            <td>{{ $item->bapb_no }}</td>
            <td>{{ $item->no_container }}</td>
            <td>{{ $item->destination }}</td>
            <td>{{ $item->sailing_date }}</td>
            <td>{{ $item->senders }}</td>
            <td>{{ $item->harga }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6" align="right">Sub Total</td>
        <td>
            {{ $subTotal  }}
        </td>
    </tr>
    @if($invoice->is_pph === true)
        <tr>
            <td colspan="6" align="right">Potongan PPH {{ $pph23 }}%</td>
            <td>
                {{ $totalPph }}
            </td>
        </tr>
        <tr>
            <td colspan="6" align="right">Total setelah potongan PPH</td>
            <td>
                {{ $subTotal - $totalPph  }}
            </td>
        </tr>
    @endif
    @foreach($bapbList as $bapbIdx => $bapb)
        @foreach($bapb->costs as $costIdx => $cost)
            <tr>
                <td colspan="3">
                    {{ $cost->sender }}
                </td>
                <td colspan="3">
                    {{ $cost->name }}
                </td>
                <td>
                    {{ $cost->price }}
                </td>
            </tr>
        @endforeach
    @endforeach
    <tr>
        <td colspan="6" align="right">Yang harus dibayar</td>
        <td>
            {{ $totalAll }}
        </td>
    </tr>
    </tbody>
</table>
