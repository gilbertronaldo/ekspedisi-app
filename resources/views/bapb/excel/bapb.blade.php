<table>
    <thead>
    <tr style="background-color: yellow;">
        <th>No Bapb</th>
        <th>Penerima</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bapbList as $bapb)
        <tr>
            <td>{{ $bapb->bapb_no }}</td>
            <td>{{ $bapb->recipient_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
