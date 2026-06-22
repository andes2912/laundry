@extends('layouts.backend')
@section('title','Karyawan - Laporan Laundry')
@section('header','Laporan Laundry')
@section('content')

@php
    $totalOrder  = $laporan->count();
    $totalOmzet  = $laporan->sum('harga_akhir');
    $totalLunas  = $laporan->where('status_payment','Success')->sum('harga_akhir');
    $totalKg     = $laporan->sum('kg');
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Laporan Laundry</h2>
        <p class="text-muted mb-0">Rekap seluruh transaksi. Klik baris untuk lihat detail item.</p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ url('export-excel') }}" class="btn btn-success">
            <i class="feather icon-download mr-25"></i> Export Excel
        </a>
    </div>
</div>

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $totalOrder }}</h2>
                    <p class="mb-0 text-muted">Total Order</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(115,103,240,.15);">
                    <i class="feather icon-shopping-bag text-primary" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ number_format($totalKg, 2) }}</h2>
                    <p class="mb-0 text-muted">Total Berat (kg)</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(0,207,232,.15);">
                    <i class="feather icon-package text-info" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ Rupiah::getRupiah($totalOmzet) }}</h2>
                    <p class="mb-0 text-muted">Total Omzet</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(255,159,67,.15);">
                    <i class="feather icon-trending-up text-warning" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ Rupiah::getRupiah($totalLunas) }}</h2>
                    <p class="mb-0 text-muted">Sudah Lunas</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(40,199,111,.15);">
                    <i class="feather icon-check-circle text-success" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ TABLE ============ --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Jenis Laundry</th>
                        <th>Jenis Pembayaran</th>
                        <th>Status</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $no => $row)
                        @php
                            $itemsCount = $row->items->count();
                            $formattedItems = $row->items->map(fn($it) => [
                                'jenis' => $it->jenis,
                                'kg' => (float) $it->kg,
                                'harga' => (int) $it->harga,
                                'subtotal' => (int) $it->subtotal,
                            ]);
                        @endphp
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>
                                <span class="text-bold-600">{{ $row->invoice }}</span>
                                <br><small class="text-muted">{{ $row->tgl_transaksi }}</small>
                            </td>
                            <td>{{ namaCustomer($row->customer_id) }}</td>
                            <td>
                                @if ($itemsCount > 1)
                                    <button type="button"
                                            class="btn btn-sm btn-flat-primary px-50 py-25 btn-detail-items"
                                            data-invoice="{{ $row->invoice }}"
                                            data-items="{{ json_encode($formattedItems) }}">
                                        <span class="badge badge-primary">{{ $itemsCount }}</span>
                                        <span class="ml-25">item · detail</span>
                                        <i class="feather icon-eye ml-25"></i>
                                    </button>
                                @else
                                    <span class="badge badge-light-primary">{{ optional($row->items->first())->jenis ?? optional($row->price)->jenis ?? '—' }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $jpClass = match($row->jenis_pembayaran) {
                                        'Tunai'    => 'badge-light-success',
                                        'Transfer' => 'badge-light-info',
                                        default    => 'badge-light-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $jpClass }}">{{ $row->jenis_pembayaran ?: '—' }}</span>
                            </td>
                            <td>
                                @if ($row->status_payment == 'Success')
                                    <span class="badge badge-light-success"><i class="feather icon-check"></i> Lunas</span>
                                @else
                                    <span class="badge badge-light-danger"><i class="feather icon-clock"></i> Pending</span>
                                @endif
                            </td>
                            <td class="text-right text-bold-600">{{ Rupiah::getRupiah($row->harga_akhir) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
    $('#myTable').DataTable({ order: [[0, 'desc']] });
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
