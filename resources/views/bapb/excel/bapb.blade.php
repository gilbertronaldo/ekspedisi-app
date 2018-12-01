<table>
    <thead>
    <tr>
        <th colspan="2">NO COUN</th>
        <th colspan="3">{{ $header->no_container }}</th>
        <th>TUJUAN</th>
        <th colspan="3">{{ $header->destination }}</th>
    </tr>
    <tr>
        <th colspan="2">SEAL</th>
        <th colspan="3">{{ $header->no_seal }}</th>
        <th>VOY</th>
        <th colspan="3">{{ $header->no_voyage }}</th>
    </tr>
    <tr>
        <th colspan="2">KET</th>
        <th colspan="3">SD {{ $header->last_entry }}</th>
        <th>KAPAL</th>
        <th colspan="3">{{ $header->ship_name }}</th>
    </tr>
    <tr>
        <th colspan="2">NAMA BARANG</th>
        <th colspan="3">CAMPURAN</th>
        <TH>TGL. BRGKT</TH>
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
    <tr style="background-color: yellow;">
        <th>NO</th>
        <th>NO BAPB</th>
        <th>PENERIMA</th>
        <th>PENGIRIM</th>
        <th>JML/KOLI</th>
        <th>JENIS BARANG</th>
        <th>KEMASAN</th>
        <th>KET</th>
        <th>HARGA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $itemIdx => $item)
        <tr>
            <td>{{ $itemIdx + 1 }}</td>
            <td>{{ $item->date }}</td>
            <td>{{ $item->recipient_name }}</td>
            <td>{{ $item->sender_name }}</td>
            <td>{{ $item->koli }}</td>
            <td>{{ $item->bapb_sender_item_name }}</td>
            <td>{{ $item->kemasan }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
