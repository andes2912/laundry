@extends('layouts.backend')
@section('title','Tambah Order')
@section('header','Tambah Order')
@section('content')

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('home') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('pelayanan') }}" class="text-muted">Order</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
        <h2 class="text-bold-700 mb-25">Tambah Order Baru</h2>
        <p class="text-muted mb-0">
            Pilih customer, tambah beberapa item pakaian sekaligus, total terhitung otomatis di kanan.
        </p>
    </div>
</div>

@if($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i>
        <strong>Ada {{ $errors->count() }} kesalahan:</strong>
        <ul class="mb-0 mt-50">
            @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pelayanan.store') }}" method="POST" id="order-form">
    @csrf

    <div class="row">

        {{-- ============ KIRI: DETAIL ORDER ============ --}}
        <div class="col-lg-8 col-12">

            {{-- Card: Customer & Invoice --}}
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-user mr-50 text-primary"></i> Customer &amp; Invoice
                        </h4>
                    </div>
                    <a href="{{ url('customers-create') }}" class="btn btn-flat-primary btn-sm">
                        <i class="feather icon-user-plus mr-25"></i> Customer Baru
                    </a>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-md-7 col-12">
                            <div class="form-group mb-0">
                                <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id"
                                        class="form-control @error('customer_id') is-invalid @enderror" required>
                                    <option value="">— Pilih Customer —</option>
                                    @foreach ($customer as $c)
                                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }} @if($c->no_telp) · {{ $c->no_telp }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="form-group mb-0">
                                <label for="invoice">No. Invoice</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-hash"></i></span>
                                    </div>
                                    <input type="text" name="invoice" id="invoice" value="{{ $newID }}"
                                           class="form-control text-bold-600" readonly>
                                </div>
                                <small class="text-muted">Auto-generate.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Item Laundry (multi-item) --}}
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-package mr-50 text-info"></i> Item Laundry
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">
                            Bisa tambah beberapa jenis pakaian sekaligus dengan klik <strong>+ Tambah Item</strong>.
                        </p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="btn-add-item">
                        <i class="feather icon-plus mr-25"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body pt-2">
                    <div id="items-wrap">
                        {{-- Item rows dibuat oleh JS --}}
                    </div>
                </div>
            </div>

            {{-- Card: Pembayaran --}}
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-0">
                        <i class="feather icon-credit-card mr-50 text-success"></i> Pembayaran
                    </h4>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-0">
                                <label for="status_payment">Status Pembayaran <span class="text-danger">*</span></label>
                                <select name="status_payment" id="status_payment"
                                        class="form-control @error('status_payment') is-invalid @enderror" required>
                                    <option value="">— Pilih —</option>
                                    <option value="Pending" {{ old('status_payment') == 'Pending' ? 'selected' : '' }}>Belum Dibayar</option>
                                    <option value="Success" {{ old('status_payment') == 'Success' ? 'selected' : '' }}>Sudah Dibayar</option>
                                </select>
                                @error('status_payment')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-0">
                                <label for="jenis_pembayaran">Jenis Pembayaran <span class="text-danger">*</span></label>
                                <select name="jenis_pembayaran" id="jenis_pembayaran"
                                        class="form-control @error('jenis_pembayaran') is-invalid @enderror" required>
                                    <option value="">— Pilih —</option>
                                    <option value="Tunai"           {{ old('jenis_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                                    <option value="Transfer"        {{ old('jenis_pembayaran') == 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="Belum Diketahui" {{ old('jenis_pembayaran') == 'Belum Diketahui' ? 'selected' : '' }}>Belum Diketahui</option>
                                </select>
                                <small class="text-muted">Pilih "Belum Diketahui" jika customer akan tentukan nanti.</small>
                                @error('jenis_pembayaran')<small class="text-danger d-block">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-0">
                                <label for="disc-input">Diskon Total (%)</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" name="disc" id="disc-input" min="0" max="100" step="0.01"
                                           value="{{ old('disc') }}"
                                           class="form-control @error('disc') is-invalid @enderror"
                                           placeholder="0" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Berlaku ke total semua item.</small>
                                @error('disc')<small class="text-danger d-block">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KANAN: SUMMARY ============ --}}
        <div class="col-lg-4 col-12">
            <div class="card" style="position: sticky; top: 90px;">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-0">
                        <i class="feather icon-file-text mr-50 text-warning"></i> Ringkasan Order
                    </h4>
                </div>
                <div class="card-body pt-2">
                    <div id="items-summary" class="mb-1">
                        <small class="text-muted">Belum ada item dipilih.</small>
                    </div>

                    <div class="d-flex justify-content-between mb-50 pt-1 border-top">
                        <span class="text-muted">Total Berat</span>
                        <span class="text-bold-600" id="sum-kg">0 kg</span>
                    </div>
                    <div class="d-flex justify-content-between mb-50">
                        <span class="text-muted">Lama Pengerjaan</span>
                        <span class="text-bold-600" id="sum-hari">— hari</span>
                    </div>
                    <div class="d-flex justify-content-between mb-50">
                        <span class="text-muted">Subtotal</span>
                        <span class="text-bold-600" id="sum-subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1" id="row-disc" style="display:none;">
                        <span class="text-muted">Diskon (<span id="sum-disc-pct">0</span>%)</span>
                        <span class="text-danger text-bold-600" id="sum-disc">- Rp 0</span>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-bold-700">TOTAL</span>
                        <h3 class="text-bold-700 mb-0 text-success" id="sum-total">Rp 0</h3>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mb-50">
                        <i class="feather icon-check mr-25"></i> Simpan Order
                    </button>
                    <a href="{{ url('pelayanan') }}" class="btn btn-outline-secondary btn-block">
                        <i class="feather icon-x mr-25"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- ============ ITEM ROW TEMPLATE (rendered by JS) ============ --}}
<template id="item-row-template">
    <div class="item-row p-1 mb-1" style="background: rgba(115,103,240,.04); border: 1px solid var(--border, rgba(115,103,240,.15)); border-radius: 8px;">
        <div class="row align-items-end">
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label>Jenis Pakaian <span class="text-danger">*</span></label>
                    <select name="items[__IDX__][harga_id]" class="form-control item-harga" required>
                        <option value="">— Pilih Jenis —</option>
                        @foreach ($jenisPakaian as $j)
                            <option value="{{ $j->id }}"
                                    data-harga="{{ $j->harga }}"
                                    data-hari="{{ $j->hari }}"
                                    data-jenis="{{ $j->jenis }}">
                                {{ $j->jenis }} · {{ Rupiah::getRupiah($j->harga) }} / kg
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="form-group mb-0">
                    <label>Berat (kg) <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <input type="number" name="items[__IDX__][kg]" class="form-control item-kg"
                               step="0.1" min="0.1" placeholder="0.0" required autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="form-group mb-0">
                    <label>Subtotal</label>
                    <div class="form-control item-subtotal text-bold-600" style="background: transparent; border: none; padding-left: 0;">Rp 0</div>
                </div>
            </div>
            <div class="col-md-1 col-2 text-right">
                <button type="button" class="btn btn-flat-danger btn-sm btn-remove-item" title="Hapus item">
                    <i class="feather icon-trash-2"></i>
                </button>
            </div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
(function() {
    var template = document.getElementById('item-row-template').innerHTML;
    var idx = 0;

    function rupiah(n) {
        return 'Rp ' + (Math.round(n) || 0).toLocaleString('id-ID');
    }

    function addItem() {
        var html = template.replace(/__IDX__/g, idx++);
        $('#items-wrap').append(html);
        recalcAll();
    }

    function removeItem(btn) {
        // Pastikan minimal 1 item
        if ($('#items-wrap .item-row').length <= 1) {
            alert('Minimal harus ada 1 item.');
            return;
        }
        $(btn).closest('.item-row').remove();
        recalcAll();
    }

    function recalcRow($row) {
        var $opt = $row.find('.item-harga option:selected');
        var harga = parseInt($opt.data('harga') || 0, 10);
        var kg    = parseFloat($row.find('.item-kg').val() || 0);
        var sub   = harga * kg;
        $row.find('.item-subtotal').text(rupiah(sub));
        $row.data('subtotal', sub);
        $row.data('hari', parseInt($opt.data('hari') || 0, 10));
        $row.data('jenis', $opt.data('jenis') || '');
        $row.data('kg', kg);
    }

    function recalcAll() {
        var subtotal = 0;
        var totalKg  = 0;
        var maxHari  = 0;
        var summary  = [];

        $('#items-wrap .item-row').each(function() {
            recalcRow($(this));
            var s = parseInt($(this).data('subtotal') || 0, 10);
            var k = parseFloat($(this).data('kg') || 0);
            var h = parseInt($(this).data('hari') || 0, 10);
            var j = $(this).data('jenis') || '';
            subtotal += s; totalKg += k;
            if (h > maxHari) maxHari = h;
            if (j && k) summary.push({ jenis: j, kg: k, sub: s });
        });

        var disc = parseFloat($('#disc-input').val() || 0);
        var discAmt = (disc > 0) ? (subtotal * disc / 100) : 0;
        var total = subtotal - discAmt;

        $('#sum-kg').text((totalKg.toFixed(2) * 1) + ' kg');
        $('#sum-hari').text(maxHari ? (maxHari + ' hari') : '— hari');
        $('#sum-subtotal').text(rupiah(subtotal));
        if (disc > 0) {
            $('#row-disc').css('display', 'flex');
            $('#sum-disc-pct').text(disc);
            $('#sum-disc').text('- ' + rupiah(discAmt));
        } else {
            $('#row-disc').hide();
        }
        $('#sum-total').text(rupiah(total));

        // Render mini summary list di atas
        var $sum = $('#items-summary').empty();
        if (summary.length === 0) {
            $sum.html('<small class="text-muted">Belum ada item dipilih.</small>');
        } else {
            summary.forEach(function(s) {
                var line = '<div class="d-flex justify-content-between mb-25" style="font-size:.85rem;">'
                         + '<span class="text-muted">' + s.jenis + ' · ' + s.kg + 'kg</span>'
                         + '<span>' + rupiah(s.sub) + '</span>'
                         + '</div>';
                $sum.append(line);
            });
        }
    }

    // Event listeners
    $(document).on('change input', '.item-harga, .item-kg', recalcAll);
    $(document).on('input change', '#disc-input', recalcAll);
    $(document).on('click', '#btn-add-item', addItem);
    $(document).on('click', '.btn-remove-item', function() { removeItem(this); });

    // Init dengan 1 row default
    addItem();
})();
</script>
@endsection
