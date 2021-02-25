<header>
    <div style="float: left;margin-left: 50px;">
        <img src="{{ public_path('img/logo.png') }}" alt="" width="100" height="100">
    </div>
    <div style="margin-left: 50px;">
        <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
        @if($invoice->is_pph === true)
            <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
        @else
            <h2 style="margin: 2px;padding: 0;">SUMBER REJEKI</h2>
        @endif
        <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
        <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta
            Utara</h5>
        <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
    </div>
    <div style="text-align: center;width: 100%;">
        <h2>INVOICE</h2>
    </div>
    <div style="width: 100%;font-size: 16px;margin: -30px 5px 5px;text-align: left">
        <span>No.</span>&nbsp;<span class="t-b">{{ $invoice->invoice_no }}</span>
        <br>
        <span class="t-b">{{ $invoice->tgl }}</span>
    </div>
</header>
