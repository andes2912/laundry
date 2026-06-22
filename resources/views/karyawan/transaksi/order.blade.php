@extends('layouts.backend')
@section('title','Karyawan - Order Masuk')
@section('header','Order Masuk')
@section('content')

@php
    $total    = $order->count();
    $process  = $order->where('status_order', 'Process')->count();
    $done     = $order->where('status_order', 'Done')->count();
    $delivery = $order->where('status_order', 'Delivery')->count();
    $pending  = $order->where('status_payment', 'Pending')->count();
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Daftar Order</h2>
        <p class="text-muted mb-0">
            Semua order kamu. Klik tombol di kolom Aksi untuk update status (Bayar → Selesai → Diambil).
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ url('add-order') }}" class="btn btn-primary">
            <i class="feather icon-plus mr-25"></i> Order Baru
        </a>
    </div>
</div>

{{-- ============ FLASH ============ --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-check-circle mr-50"></i> {{ $message }}
    </div>
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $total }}</h2>
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
                    <h2 class="text-bold-700 mb-0">{{ $process }}</h2>
                    <p class="mb-0 text-muted">Sedang Diproses</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(0,207,232,.15);">
                    <i class="feather icon-refresh-cw text-info" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $done }}</h2>
                    <p class="mb-0 text-muted">Selesai</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(40,199,111,.15);">
                    <i class="feather icon-check-circle text-success" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $delivery }}</h2>
                    <p class="mb-0 text-muted">Sudah Diambil</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(255,159,67,.15);">
                    <i class="feather icon-check-square text-warning" style="font-size:1.2rem"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ TABLE ============ --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom flex-column flex-md-row align-items-md-center">
                <div>
                    <h4 class="card-title mb-25">Daftar Order</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">
                        @if($pending > 0)
                            <span class="badge badge-light-danger mr-25">{{ $pending }} belum dibayar</span>
                        @endif
                        Total {{ $total }} order
                    </p>
                </div>
                <div class="mt-1 mt-md-0 d-flex flex-wrap" style="gap:.5rem;">
                    <select id="filter-status" class="form-control" style="min-width:160px">
                        <option value="">Semua status</option>
                        <option value="Process">Diproses</option>
                        <option value="Done">Selesai</option>
                        <option value="Delivery">Sudah Diambil</option>
                    </select>
                    <div class="input-group input-group-merge" style="min-width:200px">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                        </div>
                        <input type="text" id="order-search" class="form-control" placeholder="Cari invoice, customer...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="order-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th class="text-right">Total</th>
                            <th class="text-center" style="width:220px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order as $no => $item)
                            @php
                                // Badge status order (proses pengerjaan)
                                $orderBadge = match($item->status_order) {
                                    'Process'  => ['badge-light-info',    'refresh-cw',   'Diproses'],
                                    'Done'     => ['badge-light-success', 'check-circle', 'Siap Diambil'],
                                    'Delivery' => ['badge-light-warning', 'check-square', 'Sudah Diambil'],
                                    default    => ['badge-light-secondary','circle',       $item->status_order],
                                };
                                $payBadge = $item->status_payment === 'Success'
                                    ? ['badge-light-success', 'check',  'Lunas']
                                    : ['badge-light-danger',  'clock',  'Belum Bayar'];

                                // Tentukan aksi selanjutnya — satu langkah saja
                                $needsJp = empty($item->jenis_pembayaran) || $item->jenis_pembayaran === 'Belum Diketahui';
                                $nextAction = null;
                                if ($item->status_payment === 'Pending') {
                                    $nextAction = [
                                        'label'      => 'Tandai Lunas',
                                        'short'      => 'Bayar',
                                        'icon'       => 'dollar-sign',
                                        'btnClass'   => 'btn-outline-danger',
                                        'confirmCls' => 'btn-danger',
                                        'message'    => $needsJp
                                            ? 'Pilih jenis pembayaran lalu tandai order ini sebagai <b>sudah dibayar</b>.'
                                            : 'Tandai order ini sebagai <b>sudah dibayar</b>?',
                                    ];
                                } elseif ($item->status_order === 'Process') {
                                    $nextAction = [
                                        'label'      => 'Tandai Selesai',
                                        'short'      => 'Selesai',
                                        'icon'       => 'check-circle',
                                        'btnClass'   => 'btn-outline-info',
                                        'confirmCls' => 'btn-info',
                                        'message'    => 'Tandai laundry ini sebagai <b>selesai diproses</b>? Customer akan menerima notifikasi.',
                                    ];
                                } elseif ($item->status_order === 'Done') {
                                    $nextAction = [
                                        'label'      => 'Tandai Diambil',
                                        'short'      => 'Diambil',
                                        'icon'       => 'check-square',
                                        'btnClass'   => 'btn-outline-warning',
                                        'confirmCls' => 'btn-warning',
                                        'message'    => 'Tandai laundry ini sebagai <b>sudah diambil</b> oleh customer?',
                                    ];
                                }

                                $formattedItems = $item->items->map(fn($it) => [
                                    'jenis' => $it->jenis,
                                    'kg' => (float) $it->kg,
                                    'harga' => (int) $it->harga,
                                    'subtotal' => (int) $it->subtotal
                                ]);
                            @endphp
                            <tr data-status="{{ $item->status_order }}">
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <span class="text-bold-600">{{ $item->invoice }}</span>
                                    <br><small class="text-muted">{{ carbon\carbon::parse($item->tgl_transaksi)->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <i class="feather icon-user mr-25 text-muted"></i> {{ $item->customer }}
                                </td>
                                <td>
                                    @php $itemsCount = $item->items->count(); @endphp
                                    @if ($itemsCount > 1)
                                        <button type="button"
                                                class="btn btn-sm btn-flat-primary px-50 py-25 btn-detail-items"
                                                data-invoice="{{ $item->invoice }}"
                                                data-items="{{ json_encode($formattedItems) }}">
                                            <span class="badge badge-primary">{{ $itemsCount }}</span>
                                            <span class="ml-25">item · detail</span>
                                            <i class="feather icon-eye ml-25"></i>
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
                                </td>
                                <td class="text-right text-bold-600">{{ Rupiah::getRupiah($item->harga_akhir) }}</td>
                                <td class="text-center">
                                    @if ($nextAction)
                                        <button class="btn btn-sm {{ $nextAction['btnClass'] }} updateStatus mb-25"
                                                style="min-width:150px;"
                                                data-id-update="{{ $item->id }}"
                                                data-invoice="{{ $item->invoice }}"
                                                data-customer="{{ $item->customer }}"
                                                data-action="{{ $nextAction['short'] }}"
                                                data-message="{{ $nextAction['message'] }}"
                                                data-confirm-class="{{ $nextAction['confirmCls'] }}"
                                                data-confirm-icon="{{ $nextAction['icon'] }}"
                                                data-needs-payment="{{ $needsJp && $item->status_payment === 'Pending' ? '1' : '0' }}"
                                                title="{{ $nextAction['label'] }}">
                                            <i class="feather icon-{{ $nextAction['icon'] }} mr-25"></i>{{ $nextAction['label'] }}
                                        </button>
                                    @else
                                        <span class="badge badge-light-success mb-25" style="min-width:150px; padding:.45rem;">
                                            <i class="feather icon-check-circle mr-25"></i> Order Selesai
                                        </span>
                                    @endif
                                    <br>
                                    <a href="{{ url('invoice-kar', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary" style="min-width:150px;"
                                       title="Lihat invoice" target="_blank">
                                        <i class="feather icon-file-text mr-25"></i> Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="feather icon-inbox font-medium-5 d-block mb-1"></i>
                                    Belum ada order. Klik <strong>Order Baru</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body py-1 border-top">
                <small class="text-muted">Menampilkan <span id="visible-count">{{ $total }}</span> dari {{ $total }} order</small>
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL: KONFIRMASI UPDATE STATUS ============ --}}
<div class="modal fade" id="modal-confirm-status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="feather icon-alert-circle mr-50 text-warning"></i>
                    Konfirmasi Update Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-1" id="mcs-message">—</p>
                <div class="p-1 mb-1" style="background: rgba(115,103,240,.05); border-radius: 6px;">
                    <div class="d-flex justify-content-between mb-25">
                        <span class="text-muted">Invoice</span>
                        <span class="text-bold-600" id="mcs-invoice">—</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Customer</span>
                        <span class="text-bold-600" id="mcs-customer">—</span>
                    </div>
                </div>

                {{-- Pilih jenis pembayaran (tampil hanya kalau dibutuhkan) --}}
                <div id="mcs-payment-section" style="display:none;">
                    <div class="alert alert-warning mb-1" style="font-size:.85rem;">
                        <i class="feather icon-info mr-25"></i>
                        Customer ini belum menentukan jenis pembayaran. <b>Wajib dipilih</b> sebelum tandai lunas.
                    </div>
                    <label class="text-bold-600">Jenis Pembayaran <span class="text-danger">*</span></label>
                    <div class="d-flex" style="gap:.5rem;">
                        <label class="d-flex align-items-center justify-content-center flex-fill p-1 mb-0"
                               style="border:2px solid #e5e7eb; border-radius:6px; cursor:pointer;">
                            <input type="radio" name="mcs_jp" value="Tunai" class="mr-50">
                            <i class="feather icon-dollar-sign mr-25 text-success"></i> <b>Tunai</b>
                        </label>
                        <label class="d-flex align-items-center justify-content-center flex-fill p-1 mb-0"
                               style="border:2px solid #e5e7eb; border-radius:6px; cursor:pointer;">
                            <input type="radio" name="mcs_jp" value="Transfer" class="mr-50">
                            <i class="feather icon-credit-card mr-25 text-info"></i> <b>Transfer</b>
                        </label>
                    </div>
                    <small id="mcs-payment-error" class="text-danger d-none mt-50 d-block">
                        <i class="feather icon-alert-circle mr-25"></i> Pilih salah satu jenis pembayaran.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="feather icon-x mr-25"></i> Batal
                </button>
                <button type="button" class="btn" id="mcs-confirm">
                    <i class="feather icon-check mr-25" id="mcs-confirm-icon"></i> <span id="mcs-confirm-label">Ya, Lanjutkan</span>
                </button>
            </div>
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
// ===== Update status laundry (dengan konfirmasi) =====
var pendingUpdate = null; // { id, $btn }

$(document).on('click', '.updateStatus', function () {
    var $btn = $(this);
    var needsPayment = String($btn.data('needs-payment') || '0') === '1';
    pendingUpdate = { id: $btn.attr('data-id-update'), $btn: $btn, needsPayment: needsPayment };

    $('#mcs-message').html($btn.data('message') || 'Yakin update status order ini?');
    $('#mcs-invoice').text($btn.data('invoice') || '-');
    $('#mcs-customer').text($btn.data('customer') || '-');
    $('#mcs-confirm-label').text('Ya, ' + ($btn.data('action') || 'Lanjutkan'));

    var $cbtn = $('#mcs-confirm');
    $cbtn.removeClass('btn-danger btn-info btn-warning btn-success btn-primary')
         .addClass($btn.data('confirm-class') || 'btn-primary');
    $('#mcs-confirm-icon').attr('class', 'feather icon-' + ($btn.data('confirm-icon') || 'check') + ' mr-25');

    // Show/hide payment picker
    $('input[name=mcs_jp]').prop('checked', false);
    $('#mcs-payment-error').addClass('d-none');
    $('#mcs-payment-section').toggle(needsPayment);

    $('#modal-confirm-status').modal('show');
});

// Visual feedback radio (highlight border)
$(document).on('change', 'input[name=mcs_jp]', function () {
    $('input[name=mcs_jp]').each(function () {
        var $lbl = $(this).closest('label');
        if ($(this).is(':checked')) {
            $lbl.css('border-color', '#7367f0').css('background', 'rgba(115,103,240,.06)');
        } else {
            $lbl.css('border-color', '#e5e7eb').css('background', 'transparent');
        }
    });
    $('#mcs-payment-error').addClass('d-none');
});

$(document).on('click', '#mcs-confirm', function () {
    if (!pendingUpdate) return;

    var payload = {
        '_token': $('meta[name=csrf-token]').attr('content'),
        id: pendingUpdate.id
    };

    if (pendingUpdate.needsPayment) {
        var jp = $('input[name=mcs_jp]:checked').val();
        if (!jp) {
            $('#mcs-payment-error').removeClass('d-none');
            return;
        }
        payload.jenis_pembayaran = jp;
    }

    var $cbtn = $(this).prop('disabled', true).html('<i class="feather icon-loader"></i> Memproses...');
    var $rowBtn = pendingUpdate.$btn;
    $rowBtn.prop('disabled', true).html('<i class="feather icon-loader"></i> ...');

    $.get('update-status-laundry', payload, function () {
        location.reload();
    }).fail(function (xhr) {
        var msg = 'Gagal update status. Coba lagi.';
        if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON.error;
        $cbtn.prop('disabled', false).html('<i class="feather icon-check mr-25"></i> Coba Lagi');
        $rowBtn.prop('disabled', false);
        alert(msg);
    });
});

// Reset state ketika modal ditutup tanpa konfirmasi
$('#modal-confirm-status').on('hidden.bs.modal', function () {
    pendingUpdate = null;
    $('#mcs-confirm').prop('disabled', false);
    $('#mcs-confirm-label').text('Ya, Lanjutkan');
    $('#mcs-payment-section').hide();
    $('#mcs-payment-error').addClass('d-none');
    $('input[name=mcs_jp]').prop('checked', false)
        .closest('label').css('border-color', '#e5e7eb').css('background', 'transparent');
});

// ===== Combined filter (search + status) =====
function applyFilter() {
    var q  = $('#order-search').val().toLowerCase().trim();
    var st = $('#filter-status').val();
    var visible = 0;
    $('#order-table tbody tr').each(function() {
        if ($(this).attr('id') === 'empty-row') return;
        var text       = $(this).text().toLowerCase();
        var rowStatus  = $(this).data('status') || '';
        var matchQ     = !q || text.indexOf(q) !== -1;
        var matchSt    = !st || rowStatus === st;
        var show       = matchQ && matchSt;
        $(this).toggle(show);
        if (show) visible++;
    });
    $('#visible-count').text(visible);
    $('#no-match').remove();
    if (visible === 0 && (q || st)) {
        $('#order-table tbody').append(
            '<tr id="no-match"><td colspan="7" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada order yang cocok</td></tr>'
        );
    }
}
$('#order-search, #filter-status').on('input change', applyFilter);

// ===== Detail item modal =====
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
