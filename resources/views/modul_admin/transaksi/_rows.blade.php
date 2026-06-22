@foreach ($transaksi as $key => $item)
    @php
        $orderBadge = match($item->status_order) {
            'Process'  => ['badge-light-info',    'refresh-cw',   'Diproses'],
            'Done'     => ['badge-light-success', 'check-circle', 'Siap Diambil'],
            'Delivery' => ['badge-light-warning', 'check-square', 'Sudah Diambil'],
            default    => ['badge-light-secondary','circle',       $item->status_order],
        };
        $payBadge = $item->status_payment === 'Success'
            ? ['badge-light-success', 'check',  'Lunas']
            : ['badge-light-danger',  'clock',  'Belum Bayar'];
        $itemsCount = $item->items->count();
        $formattedItems = $item->items->map(fn($it) => [
            'jenis' => $it->jenis,
            'kg' => (float) $it->kg,
            'harga' => (int) $it->harga,
            'subtotal' => (int) $it->subtotal,
        ]);
    @endphp
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>
            <span class="text-bold-600">{{ $item->invoice }}</span>
            <br><small class="text-muted">{{ carbon\carbon::parse($item->tgl_transaksi)->format('d M Y') }}</small>
        </td>
        <td>
            <i class="feather icon-user mr-25 text-muted"></i>{{ $item->customer }}
            @if ($item->user)
                <br><small class="text-muted">Cabang: {{ $item->user->nama_cabang }}</small>
            @endif
        </td>
        <td>
            @if ($itemsCount > 1)
                <button type="button"
                        class="btn btn-sm btn-flat-primary px-50 py-25 btn-detail-items"
                        data-invoice="{{ $item->invoice }}"
                        data-items="{{ json_encode($formattedItems) }}">
                    <span class="badge badge-primary">{{ $itemsCount }}</span>
                    <span class="ml-25">item · detail</span>
                </button>
            @else
                <span class="badge badge-light-primary">{{ optional($item->items->first())->jenis ?? optional($item->price)->jenis ?? '—' }}</span>
            @endif
            <br><small class="text-muted">{{ $item->kg }} kg</small>
        </td>
        <td>
            <span class="badge {{ $orderBadge[0] }} mb-25" style="min-width:110px;">
                <i class="feather icon-{{ $orderBadge[1] }}"></i> {{ $orderBadge[2] }}
            </span>
            <br>
            <span class="badge {{ $payBadge[0] }}" style="min-width:110px;">
                <i class="feather icon-{{ $payBadge[1] }}"></i> {{ $payBadge[2] }}
            </span>
            <br><small class="text-muted">{{ $item->jenis_pembayaran ?: '—' }}</small>
        </td>
        <td class="text-right text-bold-600">{{ Rupiah::getRupiah($item->harga_akhir) }}</td>
        <td class="text-center">
            <a href="{{ url('invoice-customer', $item->invoice) }}"
               class="btn btn-sm btn-outline-primary" target="_blank">
                <i class="feather icon-file-text mr-25"></i> Invoice
            </a>
        </td>
    </tr>
@endforeach
