<header>
    <div style="float: left;margin-left: 50px;">
        @if($tipe === 'sr')
            <img src="{{ public_path('img/logo-sr.png') }}" alt="" width="100" height="100">
        @else
            <img src="{{ public_path('img/logo-srsm.png') }}" alt="" width="100" height="100">
        @endif
    </div>
    <div>
        @if($tipe === 'sr')
            <div style="text-align:left;margin-left: 50px;font-family: 'Times New Roman',serif;">
                <h4 style="margin-bottom: 6px;padding: 0;">EKSPEDISI</h4>
                <h2 style="margin: 2px;padding: 0;">SUMBER REJEKI</h2>
                <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
                <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62
                    Jakarta
                    Utara</h5>
                <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6122087</h5>
            </div>
        @else
            <div style="margin-right: 50px;text-align: center;">
                <h4 style="margin-bottom: 6px;padding: 0;">EKSPEDISI</h4>
                <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
                <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
                <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62
                    Jakarta
                    Utara</h5>
                <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6122087</h5>
            </div>
        @endif

    </div>
    <div style="text-align: center;width: 100%;">
        <h2>BERITA ACARA PENYERAHAN BARANG</h2>
    </div>

</header>
