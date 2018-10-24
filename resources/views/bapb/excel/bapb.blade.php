<table>
    <thead>
    <tr>
        <th colspan="2">NO COUN</th>
        <th colspan="3"></th>
        <th>TUJUAN</th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <th colspan="2">SEAL</th>
        <th colspan="3"></th>
        <th>VOY</th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <th colspan="2">KET</th>
        <th colspan="3"></th>
        <th>KAPAL</th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <th colspan="2">NAMA BARANG</th>
        <th colspan="3"></th>
        <TH>TGL. BRGKT</TH>
        <th colspan="3"></th>
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
        <th>PENGIRIM</th>
        <th>PENERIMA</th>
        <th>JML/KOLI</th>
        <th>JENIS BARANG</th>
        <th>KEMASAN</th>
        <th>KET</th>
        <th>UKURAN</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bapbList as $bapbIdx => $bapb)
        <tr>
            <td>{{ $bapbIdx + 1 }}</td>
            <td>{{ $bapb->bapb_no }}</td>
            <td>{{ $bapb->recipient->recipient_name }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
