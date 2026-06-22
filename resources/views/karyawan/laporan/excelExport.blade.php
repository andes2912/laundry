@php
    $totalCols = 10;
    $grand     = 0;
    $grandKg   = 0;
@endphp
<table>
    <thead>
        <tr><th colspan="{{ $totalCols }}" style="text-align:center; font-size:14pt;"><b>LAPORAN LAUNDRY</b></th></tr>
        <tr><th colspan="{{ $totalCols }}" style="text-align:center;"><b>{{ strtoupper(Auth::user()->name) }}</b></th></tr>
        <tr><th colspan="{{ $totalCols }}" style="text-align:center;">Dicetak: {{ now()->format('d M Y H:i') }}</th></tr>
        <tr><th colspan="{{ $totalCols }}">&nbsp;</th></tr>
        <tr>
            <th><b>No</b></th>
            <th><b>Tanggal</b></th>
            <th><b>Invoice</b></th>
            <th><b>Customer</b></th>
            <th><b>Jenis Pakaian</b></th>
            <th><b>Berat (kg)</b></th>
            <th><b>Harga/kg</b></th>
            <th><b>Subtotal</b></th>
            <th><b>Jenis Pembayaran</b></th>
            <th><b>Status Pembayaran</b></th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($data as $trx)
            @php
                $items = $trx->items;
                $rowspan = max($items->count(), 1);
                $first = true;
            @endphp
            @forelse ($items as $it)
                @php
                    $sub = (int) ($it->subtotal ?: round($it->kg * $it->harga));
                    $grand   += $sub;
                    $grandKg += (float) $it->kg;
                @endphp
                <tr>
                    @if ($first)
                        <td rowspan="{{ $rowspan }}">{{ $no }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $trx->tgl_transaksi }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $trx->invoice }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $trx->customer }}</td>
                    @endif
                    <td>{{ $it->jenis ?: optional($trx->price)->jenis }}</td>
                    <td>{{ $it->kg }}</td>
                    <td>{{ $it->harga }}</td>
                    <td>{{ $sub }}</td>
                    @if ($first)
                        <td rowspan="{{ $rowspan }}">{{ $trx->jenis_pembayaran ?: '-' }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $trx->status_payment }}</td>
                    @endif
                </tr>
                @php $first = false; @endphp
            @empty
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $trx->tgl_transaksi }}</td>
                    <td>{{ $trx->invoice }}</td>
                    <td>{{ $trx->customer }}</td>
                    <td>{{ optional($trx->price)->jenis }}</td>
                    <td>{{ $trx->kg }}</td>
                    <td>{{ $trx->harga }}</td>
                    <td>{{ $trx->harga_akhir }}</td>
                    <td>{{ $trx->jenis_pembayaran ?: '-' }}</td>
                    <td>{{ $trx->status_payment }}</td>
                </tr>
            @endforelse
            @php $no++; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align:right;"><b>GRAND TOTAL</b></th>
            <th><b>{{ number_format($grandKg, 2) }}</b></th>
            <th></th>
            <th><b>{{ $grand }}</b></th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>
