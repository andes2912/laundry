@php
    $grandTotal = 0;
    foreach ($data->items as $it) {
        $grandTotal += (int) ($it->subtotal ?: round($it->kg * $it->harga));
    }
    $discPct = (float) ($data->disc ?: 0);
    $discAmt = (int) round($grandTotal * $discPct / 100);
    $totalKg = $data->items->sum('kg');
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $data->invoice }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; margin: 0; }
        .wrap { padding: 20px 30px; }
        h1.title { margin: 0; font-size: 28px; letter-spacing: 2px; color: #222; }
        .head-tbl { width: 100%; border-bottom: 2px solid #333; padding-bottom: 6px; margin-bottom: 14px; }
        .head-tbl td { vertical-align: top; padding: 0; }
        .meta { text-align: right; font-size: 11px; }
        .meta .invoice-no { font-size: 14px; font-weight: bold; color: #444; }
        .status { display: inline-block; padding: 4px 10px; border-radius: 3px; font-weight: bold; font-size: 11px; }
        .status-success { background: #e6f7ed; color: #1e7e34; border: 1px solid #1e7e34; }
        .status-pending { background: #fdecea; color: #c0392b; border: 1px solid #c0392b; }
        .parties { width: 100%; margin-bottom: 14px; }
        .parties td { width: 50%; vertical-align: top; padding: 0 8px 0 0; }
        .parties h3 { margin: 0 0 4px; font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .parties h4 { margin: 0 0 4px; font-size: 14px; color: #222; }
        .parties p { margin: 0; line-height: 1.5; }
        .dates { width: 100%; background: #f7f7f9; margin-bottom: 14px; }
        .dates td { padding: 8px 12px; width: 33%; }
        .dates .lbl { color: #888; font-size: 10px; text-transform: uppercase; display:block; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table.items th { background: #333; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        table.items td { padding: 8px; border-bottom: 1px solid #eee; }
        .ta-r { text-align: right; }
        .bottom { width: 100%; }
        .bottom td { vertical-align: top; padding: 0; }
        .payment h5 { margin: 0 0 6px; font-size: 12px; }
        .payment ol { padding-left: 18px; margin: 0; font-size: 11px; }
        table.summary { width: 100%; }
        table.summary td { padding: 4px 0; }
        table.summary .total td { border-top: 2px solid #333; padding-top: 8px; font-size: 16px; font-weight: bold; color: #1e7e34; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
<div class="wrap">

    <table class="head-tbl">
        <tr>
            <td>
                <h1 class="title">INVOICE</h1>
                <div style="color:#666; margin-top:4px;">{{ $data->user->nama_cabang }}</div>
            </td>
            <td class="meta">
                <div class="invoice-no">#{{ $data->invoice }}</div>
                <div>{{ $data->created_at?->format('d M Y') }}</div>
                <div style="margin-top:6px;">
                    <span class="status {{ $data->status_payment == 'Success' ? 'status-success' : 'status-pending' }}">
                        {{ $data->status_payment == 'Success' ? 'LUNAS' : 'BELUM DIBAYAR' }}
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <table class="parties">
        <tr>
            <td>
                <h3>Dari</h3>
                <h4>{{ $data->user->nama_cabang }}</h4>
                <p>
                    Diterima: {{ $data->user->name }}<br>
                    {{ $data->user->alamat_cabang }}<br>
                    Telp: {{ $data->user->no_telp ?: '-' }}
                </p>
            </td>
            <td>
                <h3>Untuk</h3>
                <h4>{{ optional($data->customers)->name ?? $data->customer }}</h4>
                <p>
                    {{ optional($data->customers)->alamat }}<br>
                    Telp: {{ optional($data->customers)->no_telp ?: '-' }}
                </p>
            </td>
        </tr>
    </table>

    <table class="dates">
        <tr>
            <td>
                <span class="lbl">Tanggal Masuk</span>
                <b>{{ carbon\carbon::parse($data->tgl_transaksi)->format('d M Y') }}</b>
            </td>
            <td>
                <span class="lbl">Tanggal Diambil</span>
                <b>{{ $data->tgl_ambil ? carbon\carbon::parse($data->tgl_ambil)->format('d M Y') : 'Belum Diambil' }}</b>
            </td>
            <td>
                <span class="lbl">Jenis Pembayaran</span>
                <b>{{ $data->jenis_pembayaran ?: 'Belum Diketahui' }}</b>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Jenis Pakaian</th>
                <th class="ta-r">Berat</th>
                <th class="ta-r">Harga / kg</th>
                <th class="ta-r">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->items as $i => $it)
                @php $sub = (int) ($it->subtotal ?: round($it->kg * $it->harga)); @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <b>{{ $it->jenis ?: optional($it->harga()->first())->jenis }}</b>
                        @if ($it->hari)<br><small style="color:#888">{{ $it->hari }} hari pengerjaan</small>@endif
                    </td>
                    <td class="ta-r">{{ $it->kg }} kg</td>
                    <td class="ta-r">{{ Rupiah::getRupiah($it->harga) }}</td>
                    <td class="ta-r"><b>{{ Rupiah::getRupiah($sub) }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="bottom">
        <tr>
            <td class="payment" style="width:55%; padding-right:20px;">
                <h5>Metode Pembayaran</h5>
                @if ($bank->count())
                    <ol>
                        @foreach ($bank as $banks)
                            <li>{{ $banks->nama_bank }} — {{ $banks->no_rekening }} a/n {{ $banks->nama_pemilik }}</li>
                        @endforeach
                    </ol>
                @else
                    <p style="color:#888;">—</p>
                @endif
            </td>
            <td style="width:45%;">
                <table class="summary">
                    <tr><td>Total Berat</td><td class="ta-r">{{ $totalKg }} kg</td></tr>
                    <tr><td>Subtotal</td><td class="ta-r">{{ Rupiah::getRupiah($grandTotal) }}</td></tr>
                    @if ($discPct > 0)
                        <tr><td>Diskon ({{ $discPct }}%)</td><td class="ta-r" style="color:#c0392b;">- {{ Rupiah::getRupiah($discAmt) }}</td></tr>
                    @endif
                    <tr class="total"><td>TOTAL BAYAR</td><td class="ta-r">{{ Rupiah::getRupiah($data->harga_akhir) }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">Terima kasih atas kepercayaan Anda. Simpan invoice ini sebagai bukti transaksi.</div>
</div>
</body>
</html>
