<table>
    <thead>
    <tr>
        <th colspan="2">NO VOYAGE</th>
        <th colspan="3">{{ $header->no_voyage }}</th>
    </tr>
    <tr>
        <th colspan="2">KAPAL</th>
        <th colspan="3">{{ $header->ship_name }}</th>
    </tr>
    <tr>
        <th colspan="2">TANGGAL</th>
        <th colspan="3">{{ $header->sailing_date }}</th>
    </tr>
    <tr>
        <th></th>
    </tr>
    <tr>
        <th></th>
    </tr>
    </thead>
</table>
<table>
    <thead>
    <tr>
        <th colspan="5">**** BREAKOUT</th>
    </tr>
    <tr style="background-color: yellow;">
        <th>KODE KAPAL</th>
        <th>PENGIRIM</th>
        <th>PENERIMA</th>
        <th>NO BAPB</th>
        <th>NO CONT</th>
        <th>KOLI</th>
        <th>Kubik/ton</th>
        <th>Harga</th>
        <th>JUMLAH</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $itemIdx => $item)
        <tr>
            <td>{{ $item->no_voyage }}</td>
            <td>{{ $item->sender_name_bapb }}</td>
            <td>{{ $item->recipient_name_bapb }}</td>
            <td>{{ $item->bapb_no }}</td>
            <td>{{ $item->no_container }}</td>
            <td>{{ $item->koli }}</td>
            @if($item->berat)
                <td>{{ $item->berat }}</td>
                <td data-format="#,##0_-">{{ $item->price_ton }}</td>
                <td data-format="#,##0_-">{{ $item->total }}</td>
            @else
                <td>{{ $item->dimensi }}</td>
                <td data-format="#,##0_-">{{ $item->price_meter }}</td>
                <td data-format="#,##0_-">{{ $item->total }}</td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="8" style="text-align: right">TOTAL</td>
        <td data-format="#,##0_-">{{ $total }}</td>
    </tr>
    </tbody>
</table>
