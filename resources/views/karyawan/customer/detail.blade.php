@extends('layouts.backend')
@section('title','Karyawan - Detail Customer')
@section('header','Detail Customer')
@section('content')

@php
    $transaksi      = $customer->transaksiCustomer;
    $totalLaundry   = $transaksi->count();
    $totalKg        = $transaksi->sum('kg');
    $totalPaid      = $transaksi->where('status_payment','Success')->sum('harga_akhir');
    $totalPending   = $transaksi->where('status_payment','Pending')->sum('harga_akhir');
    $countProcess   = $transaksi->where('status_order','Process')->count();
    $countDone      = $transaksi->where('status_order','Done')->count();
    $countDelivery  = $transaksi->where('status_order','Delivery')->count();
    $lastOrder      = $transaksi->first();
    $initials       = collect(explode(' ', trim($customer->name)))->map(fn($w) => mb_substr($w,0,1))->take(2)->implode('');
@endphp

{{-- ============ BREADCRUMB ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('home') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('customers') }}" class="text-muted">Customer</a></li>
                <li class="breadcrumb-item active">{{ $customer->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    {{-- ============ KIRI: PROFIL ============ --}}
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-body text-center pb-1">
                <div class="d-inline-flex align-items-center justify-content-center text-bold-700 mb-1"
                     style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,#7367f0,#9e95f5); color:#fff; font-size:1.6rem;">
                    {{ strtoupper($initials ?: '?') }}
                </div>
                <h4 class="text-bold-700 mb-25">{{ $customer->name }}</h4>
                <p class="text-muted mb-1">
                    <i class="feather icon-user mr-25"></i>
                    {{ $customer->kelamin === 'L' ? 'Laki-laki' : ($customer->kelamin === 'P' ? 'Perempuan' : '—') }}
                </p>
                <div>
                    <span class="badge badge-light-warning mr-25" title="Point reward">
                        <i class="feather icon-star mr-25"></i> {{ $customer->point ?? 0 }} Point
                    </span>
                    @if ($customer->status === 'Active')
                        <span class="badge badge-light-success"><i class="feather icon-check"></i> Aktif</span>
                    @else
                        <span class="badge badge-light-secondary">{{ $customer->status ?: '—' }}</span>
                    @endif
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body pt-1">
                <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">
                    Kontak
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-50 d-flex">
                        <i class="feather icon-mail text-muted mr-50 mt-25"></i>
                        <span class="flex-fill" style="word-break:break-all;">{{ $customer->email ?: '—' }}</span>
                    </li>
                    <li class="mb-50 d-flex">
                        <i class="feather icon-phone text-muted mr-50 mt-25"></i>
                        <span class="flex-fill">
                            {{ $customer->no_telp && $customer->no_telp != 0 ? $customer->no_telp : 'Belum diisi' }}
                        </span>
                    </li>
                    <li class="d-flex">
                        <i class="feather icon-map-pin text-muted mr-50 mt-25"></i>
                        <span class="flex-fill">{{ $customer->alamat ?: 'Belum diisi' }}</span>
                    </li>
                </ul>
            </div>
            <hr class="my-1">
            <div class="card-body pt-1">
                <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">
                    Riwayat
                </h6>
                <div class="d-flex justify-content-between mb-50">
                    <span class="text-muted">Bergabung</span>
                    <span class="text-bold-600">{{ $customer->created_at?->format('d M Y') ?? '—' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="text-muted">Laundry Terakhir</span>
                    <span class="text-bold-600">
                        {{ $lastOrder?->created_at?->format('d M Y') ?? '—' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ KANAN: STATS + TABEL ============ --}}
    <div class="col-lg-8 col-12">
        {{-- Stat cards --}}
        <div class="row">
            <div class="col-md-3 col-6 mb-2">
                <div class="card mb-0 h-100">
                    <div class="card-body p-1 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-50"
                             style="width:42px; height:42px; border-radius:50%; background:rgba(115,103,240,.15);">
                            <i class="feather icon-shopping-bag text-primary"></i>
                        </div>
                        <h4 class="text-bold-700 mb-0">{{ $totalLaundry }}</h4>
                        <small class="text-muted">Total Order</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card mb-0 h-100">
                    <div class="card-body p-1 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-50"
                             style="width:42px; height:42px; border-radius:50%; background:rgba(0,207,232,.15);">
                            <i class="feather icon-package text-info"></i>
                        </div>
                        <h4 class="text-bold-700 mb-0">{{ number_format($totalKg, 1) }}</h4>
                        <small class="text-muted">Total Kg</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card mb-0 h-100">
                    <div class="card-body p-1 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-50"
                             style="width:42px; height:42px; border-radius:50%; background:rgba(40,199,111,.15);">
                            <i class="feather icon-check-circle text-success"></i>
                        </div>
                        <h4 class="text-bold-700 mb-0" style="font-size:1rem;">{{ Rupiah::getRupiah($totalPaid) }}</h4>
                        <small class="text-muted">Total Lunas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card mb-0 h-100">
                    <div class="card-body p-1 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-50"
                             style="width:42px; height:42px; border-radius:50%; background:rgba(234,84,85,.15);">
                            <i class="feather icon-clock text-danger"></i>
                        </div>
                        <h4 class="text-bold-700 mb-0 {{ $totalPending > 0 ? 'text-danger' : '' }}" style="font-size:1rem;">
                            {{ Rupiah::getRupiah($totalPending) }}
                        </h4>
                        <small class="text-muted">Outstanding</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status pengerjaan --}}
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title mb-0">
                    <i class="feather icon-activity mr-50 text-info"></i> Status Pengerjaan
                </h4>
            </div>
            <div class="card-body py-2">
                <div class="row text-center">
                    <div class="col-4">
                        <h3 class="text-bold-700 text-info mb-25">{{ $countProcess }}</h3>
                        <p class="text-muted mb-0"><i class="feather icon-refresh-cw mr-25"></i>Diproses</p>
                    </div>
                    <div class="col-4 border-left border-right">
                        <h3 class="text-bold-700 text-success mb-25">{{ $countDone }}</h3>
                        <p class="text-muted mb-0"><i class="feather icon-check-circle mr-25"></i>Siap Diambil</p>
                    </div>
                    <div class="col-4">
                        <h3 class="text-bold-700 text-warning mb-25">{{ $countDelivery }}</h3>
                        <p class="text-muted mb-0"><i class="feather icon-check-square mr-25"></i>Sudah Diambil</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ TABEL TRANSAKSI ============ --}}
<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title mb-0">
            <i class="feather icon-list mr-50 text-primary"></i> Riwayat Transaksi
            <small class="text-muted ml-50">({{ $totalLaundry }} order)</small>
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
                    <th>Pembayaran</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $key => $t)
                    @php
                        $orderBadge = match($t->status_order) {
                            'Process'  => ['badge-light-info',    'refresh-cw',   'Diproses'],
                            'Done'     => ['badge-light-success', 'check-circle', 'Siap Diambil'],
                            'Delivery' => ['badge-light-warning', 'check-square', 'Sudah Diambil'],
                            default    => ['badge-light-secondary','circle',       $t->status_order],
                        };
                        $payBadge = $t->status_payment === 'Success'
                            ? ['badge-light-success', 'check',  'Lunas']
                            : ['badge-light-danger',  'clock',  'Belum Bayar'];
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
                        <td><span class="text-bold-600">{{ $t->invoice }}</span></td>
                        <td>
                            {{ carbon\carbon::parse($t->tgl_transaksi)->format('d M Y') }}
                            <br><small class="text-muted">
                                Ambil: {{ $t->tgl_ambil ? carbon\carbon::parse($t->tgl_ambil)->format('d M Y') : '—' }}
                            </small>
                        </td>
                        <td>
                            @if ($itemsCount > 1)
                                <button type="button"
                                        class="btn btn-sm btn-flat-primary px-50 py-25 btn-detail-items"
                                        data-invoice="{{ $t->invoice }}"
                                        data-items="{{ json_encode($formattedItems) }}">
                                    <span class="badge badge-primary">{{ $itemsCount }}</span>
                                    <span class="ml-25">item · detail</span>
                                </button>
                            @else
                                <span class="badge badge-light-primary">{{ optional($t->items->first())->jenis ?? optional($t->price)->jenis ?? '—' }}</span>
                            @endif
                            <br><small class="text-muted">{{ $t->kg }} kg</small>
                        </td>
                        <td>
                            <span class="badge {{ $orderBadge[0] }}">
                                <i class="feather icon-{{ $orderBadge[1] }}"></i> {{ $orderBadge[2] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $payBadge[0] }}">
                                <i class="feather icon-{{ $payBadge[1] }}"></i> {{ $payBadge[2] }}
                            </span>
                            <br><small class="text-muted">{{ $t->jenis_pembayaran ?: '—' }}</small>
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
