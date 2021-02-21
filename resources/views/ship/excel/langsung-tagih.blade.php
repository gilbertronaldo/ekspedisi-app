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
        <th colspan="5">**** LANGSUNG TAGIH</th>
    </tr>
    <tr style="background-color: yellow;">
        <th>NO CONT</th>
        <th>NOTA</th>
        <th>JUMLAH</th>
        <th>PENERIMA</th>
        <th>***</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $itemIdx => $item)
        <tr>
            <td>{{ $item->no_container }}</td>
            <td>{{ $item->invoice_no }}</td>
            <td data-format="#,##0_-">{{ $item->total }}</td>
            <td>{{ $item->recipient_name }}</td>
            <td></td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td>TOTAL</td>
        <td data-format="#,##0_-">{{ $total }}</td>
    </tr>
    </tbody>
</table>
