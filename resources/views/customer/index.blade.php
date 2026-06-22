@extends('layouts.backend')
@section('title','Dashboard Customer')
@section('header','Dashboard')
@section('content')

{{-- ============ WELCOME ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="text-muted mb-0">
            Selamat datang di dashboard kamu. Pantau status laundry & riwayat transaksi di sini.
        </p>
        <small class="text-muted">{{ date('l, d F Y') }}</small>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <div class="badge badge-light-warning" style="font-size:.85rem; padding:.6rem 1rem;">
            <i class="feather icon-star mr-25"></i>
            <b>{{ Auth::user()->point ?? 0 }}</b> Point Reward
        </div>
    </div>
</div>

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $totalLaundry }}</h2>
                    <p class="mb-0 text-muted">Total Order</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(115,103,240,.15);">
                    <i class="feather icon-shopping-bag text-primary" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ number_format($totalLaundryKg, 2) }}</h2>
                    <p class="mb-0 text-muted">Total Berat (kg)</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(0,207,232,.15);">
                    <i class="feather icon-package text-info" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ Rupiah::getRupiah($totalSpent) }}</h2>
                    <p class="mb-0 text-muted">Total Pembayaran</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(40,199,111,.15);">
                    <i class="feather icon-check-circle text-success" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0 {{ $countPending > 0 ? 'text-danger' : '' }}">{{ $countPending }}</h2>
                    <p class="mb-0 text-muted">Belum Dibayar</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(234,84,85,.15);">
                    <i class="feather icon-clock text-danger" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ STATUS OVERVIEW ============ --}}
<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title mb-0">
            <i class="feather icon-activity mr-50 text-info"></i> Status Pengerjaan
        </h4>
    </div>
    <div class="card-body py-2">
        <div class="row text-center">
            <div class="col-md-4 col-12 mb-1 mb-md-0">
                <div class="d-inline-flex align-items-center justify-content-center mb-50"
                     style="width:60px; height:60px; border-radius:50%; background:rgba(0,207,232,.15);">
                    <i class="feather icon-refresh-cw text-info" style="font-size:1.6rem"></i>
                </div>
                <h3 class="text-bold-700 mb-25">{{ $countProcess }}</h3>
                <p class="text-muted mb-0">Sedang Diproses</p>
            </div>
            <div class="col-md-4 col-12 mb-1 mb-md-0">
                <div class="d-inline-flex align-items-center justify-content-center mb-50"
                     style="width:60px; height:60px; border-radius:50%; background:rgba(40,199,111,.15);">
                    <i class="feather icon-check-circle text-success" style="font-size:1.6rem"></i>
                </div>
                <h3 class="text-bold-700 mb-25">{{ $countDone }}</h3>
                <p class="text-muted mb-0">Siap Diambil</p>
            </div>
            <div class="col-md-4 col-12">
                <div class="d-inline-flex align-items-center justify-content-center mb-50"
                     style="width:60px; height:60px; border-radius:50%; background:rgba(255,159,67,.15);">
                    <i class="feather icon-check-square text-warning" style="font-size:1.6rem"></i>
                </div>
                <h3 class="text-bold-700 mb-25">{{ $countDelivery }}</h3>
                <p class="text-muted mb-0">Sudah Diambil</p>
            </div>
        </div>
    </div>
</div>

{{-- ============ TRANSAKSI ============ --}}
<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title mb-0">
            <i class="feather icon-list mr-50 text-primary"></i> Riwayat Transaksi
        </h4>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $key => $t)
                    @php
                        $statusBadge = match($t->status_order) {
                            'Done'     => ['badge-light-success', 'check', 'Siap Diambil'],
                            'Delivery' => ['badge-light-warning', 'check-square', 'Sudah Diambil'],
                            'Process'  => ['badge-light-info', 'refresh-cw', 'Diproses'],
                            default    => ['badge-light-secondary', 'circle', $t->status_order],
                        };
                        $itemsCount = $t->items->count();
                        $formattedItems = $t->items->map(fn($it) => [
                            'jenis' => $it->jenis,
                            'kg' => (float) $it->kg,
                            'harga' => (int) $it->harga,
                            'subtotal' => (int) $it->subtotal,
                        ]);
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <span class="text-bold-600">{{ $t->invoice }}</span>
                            @if ($t->user)
                                <br><small class="text-muted">{{ optional($t->user)->nama_cabang }}</small>
                            @endif
                        </td>
                        <td>{{ carbon\carbon::parse($t->tgl_transaksi)->format('d M Y') }}</td>
                        <td>
                            @if ($itemsCount > 1)
                                <button type="button"
                                        class="btn btn-sm btn-flat-primary px-50 py-25 btn-detail-items"
                                        data-invoice="{{ $t->invoice }}"
                                        data-items="{{ json_encode($formattedItems) }}">
                                    <span class="badge badge-primary">{{ $itemsCount }}</span>
                                    <span class="ml-25">item · detail</span>
                                    <i class="feather icon-eye ml-25"></i>
                                </button>
                            @else
                                <span class="badge badge-light-primary">{{ optional($t->items->first())->jenis ?? optional($t->price)->jenis ?? '—' }}</span>
                                <br><small class="text-muted">{{ $t->kg }} kg</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $statusBadge[0] }}">
                                <i class="feather icon-{{ $statusBadge[1] }}"></i> {{ $statusBadge[2] }}
                            </span>
                        </td>
                        <td>
                            @if ($t->status_payment == 'Success')
                                <span class="badge badge-light-success"><i class="feather icon-check"></i> Lunas</span>
                            @else
                                <span class="badge badge-light-danger"><i class="feather icon-clock"></i> Pending</span>
                            @endif
                        </td>
                        <td class="text-right text-bold-600">{{ Rupiah::getRupiah($t->harga_akhir) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ============ MODAL: DETAIL ITEM ============ --}}
<div class="modal fade" id="modal-item-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="feather icon-package mr-50 text-info"></i>
                    Detail Item <small class="text-muted" id="mid-invoice"></small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Jenis Pakaian</th>
                            <th class="text-right">Berat</th>
                            <th class="text-right">Harga / kg</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="mid-tbody"></tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="2">Total</th>
                            <th class="text-right" id="mid-totkg">0 kg</th>
                            <th></th>
                            <th class="text-right" id="mid-totsub">Rp 0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#myTable').DataTable({ order: [[0, 'asc']], pageLength: 10 });
});

function rupiah(n) { return 'Rp ' + (Math.round(n) || 0).toLocaleString('id-ID'); }
$(document).on('click', '.btn-detail-items', function() {
    var items = $(this).data('items') || [];
    var invoice = $(this).data('invoice') || '';
    var $tb = $('#mid-tbody').empty();
    var totKg = 0, totSub = 0;
    items.forEach(function(it, i) {
        totKg  += parseFloat(it.kg) || 0;
        totSub += parseInt(it.subtotal) || 0;
        $tb.append(
            '<tr>' +
              '<td>' + (i+1) + '</td>' +
              '<td>' + (it.jenis || '—') + '</td>' +
              '<td class="text-right">' + (parseFloat(it.kg) || 0) + ' kg</td>' +
              '<td class="text-right">' + rupiah(it.harga) + '</td>' +
              '<td class="text-right text-bold-600">' + rupiah(it.subtotal) + '</td>' +
            '</tr>'
        );
    });
    $('#mid-invoice').text('· ' + invoice);
    $('#mid-totkg').text((totKg.toFixed(2) * 1) + ' kg');
    $('#mid-totsub').text(rupiah(totSub));
    $('#modal-item-detail').modal('show');
});
</script>
@endsection
