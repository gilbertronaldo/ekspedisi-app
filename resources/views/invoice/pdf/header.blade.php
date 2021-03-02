<header>
    <div style="float: left;margin-left: 50px;">

        @if($invoice->pajak === 'pribadi' && $invoice->is_pph !== true)
            <img src="{{ public_path('img/logo-sr.png') }}" alt="" width="100" height="100">
        @else
            <img src="{{ public_path('img/logo-srsm.png') }}" alt="" width="100" height="100">
        @endif

        {{--    </div>--}}
        {{--        <div style="float: left;margin: 50px;">--}}
        {{--            <div style="padding: 5px;--}}
        {{--            border: 5px solid blue;--}}
        {{--            border-radius: 50%;">--}}
        {{--                <div style="width: 100px;--}}
        {{--            height: 100px;--}}
        {{--            font-size: 65px;--}}
        {{--            line-height: 100px;--}}
        {{--            text-align: center;--}}
        {{--            border: 2px solid blue;--}}
        {{--            color: red;--}}
        {{--            border-radius: 50%;--}}
        {{--            font-family: 'Times New Roman',serif;--}}
        {{--            font-weight: bold;--}}
        {{--            margin: auto;">--}}
        {{--                    SRSM--}}
        {{--                </div>--}}
        {{--            </div>--}}
    </div>
    @if($invoice->pajak === 'pribadi' && $invoice->is_pph !== true)
        <div style="margin-left: 50px;font-family: 'Times New Roman',serif;">
            <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
            <h2 style="margin: 2px;padding: 0;">SUMBER REJEKI</h2>
            <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
            <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta
                Utara</h5>
            <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
        </div>
    @else
        <div style="margin-right: 50px;text-align: center;">
            <h4 style="margin: 2px;padding: 0;">EKSPEDISI</h4>
            <h2 style="margin: 2px;padding: 0;">PT. SUMBER REJEKI SINAR MANDIRI</h2>
            <h4 style="margin: 2px;padding: 0;">Jasa Angukatan Container System</h4>
            <h5 style="margin: 2px;padding: 0;">Jl. Mangga Dua Raya, Ruko Grand Boutique Centre Blok D No. 62 Jakarta
                Utara</h5>
            <h5 style="margin: 2px;padding: 0;">Telp. 021-6122087, 0858 7595 9469, Fax.: 021-6240380</h5>
        </div>
    @endif
    <div style="text-align: center;width: 100%;">
        <h2>INVOICE</h2>
    </div>
    <div style="width: 100%;font-size: 16px;margin: -30px 5px 5px;text-align: left">
        <span>No.</span>&nbsp;<span class="t-b">{{ $invoice->invoice_no }}</span>
        <br>
        <span class="t-b">{{ $invoice->tgl }}</span>
    </div>
</header>
