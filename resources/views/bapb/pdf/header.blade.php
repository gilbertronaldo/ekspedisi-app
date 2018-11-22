<header>
    <div style="float: left;margin-left: 50px;">
        <img src="{{ public_path('img/logo.png') }}" alt="" width="100" height="100">
    </div>
    <div>
        <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
        <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
        <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
        <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta
            Utara</h5>
        <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
    </div>
    <div style="text-align: center;width: 100%;">
        <h4>BERITA ACARA PENYERAHAN BARANG</h4>
    </div>
    <div style="width: 100%;font-size: 16px;margin: -20px 5px 5px;text-align: left">
        <span>No.</span>&nbsp;<span class="t-b">{{ $bapb->bapb_no }}</span>
    </div>
    <div>
        <table class="table-bordered">
            <tr>
                <td>
                    PENGIRIM
                    <span class="d-ib" style="width: 49.4px;"></span>:
                    <span class="t-b"></span>
                </td>
                <td>
                    NO. VOY
                    <span class="d-ib" style="width: 15px;"></span>:
                    <span class="t-b">{{ $bapb->ship->no_voyage }}</span>
                </td>
            </tr>
            <tr>
                <td>ALAMAT
                    <span class="d-ib" style="width: 60px;"></span>:
                    <span class="t-b"></span>
                </td>
                <td>PENERIMA
                    <span class="d-ib" style="width: 5px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_name }}</span>
                </td>
            </tr>
            <tr>
                <td>NAMA KAPAL
                    <span class="d-ib" style="width: 29px;"></span>:
                    <span class="t-b">{{ $bapb->ship->ship_name }}</span>
                </td>
                <td rowspan="2" valign="top">
                    ALAMAT
                    <span class="d-ib" style="width: 16px;"></span>:
                    <span class="t-b">{{ $bapb->recipient->recipient_address }}</span>
                </td>
            </tr>
            <tr>
                <td>TGL. BERANGKAT
                    <span class="d-ib" style="width: 3.7px;"></span>:
                    <span class="t-b">{{ \Carbon\Carbon::parse($bapb->ship->sailing_date)->format('d F Y') }}</span>
                </td>
            </tr>
        </table>
    </div>
</header>
