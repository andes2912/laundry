@extends('layouts.backend')
@section('title','Admin - Data Transaksi')
@section('header','Data Transaksi')
@section('content')

@php
    $total      = $transaksi->count();
    $countLunas = $transaksi->where('status_payment','Success')->count();
    $countPend  = $transaksi->where('status_payment','Pending')->count();
    $countProc  = $transaksi->where('status_order','Process')->count();
    $totalOmzet = $transaksi->where('status_payment','Success')->sum('harga_akhir');
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <h2 class="text-bold-700 mb-25">Data Transaksi</h2>
        <p class="text-muted mb-0">Semua transaksi dari semua cabang. Filter per karyawan untuk fokus.</p>
    </div>
</div>

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $total }}</h2>
                    <p class="mb-0 text-muted">Total Transaksi</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(115,103,240,.15);">
                    <i class="feather icon-shopping-bag text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $countProc }}</h2>
                    <p class="mb-0 text-muted">Sedang Diproses</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(0,207,232,.15);">
                    <i class="feather icon-refresh-cw text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0 {{ $countPend > 0 ? 'text-danger' : '' }}">{{ $countPend }}</h2>
                    <p class="mb-0 text-muted">Belum Dibayar</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(234,84,85,.15);">
                    <i class="feather icon-clock text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-bold-700 mb-0">{{ Rupiah::getRupiah($totalOmzet) }}</h4>
                    <p class="mb-0 text-muted">Total Omzet (Lunas)</p>
                </div>
                <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(40,199,111,.15);">
                    <i class="feather icon-trending-up text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ TABLE ============ --}}
<div class="card">
    <div class="card-header border-bottom flex-column flex-md-row align-items-md-center">
        <div>
            <h4 class="card-title mb-25">Daftar Transaksi</h4>
            <p class="card-text font-small-2 mb-0 text-muted">
                {{ $countLunas }} lunas · {{ $countPend }} pending
            </p>
        </div>
        <div class="mt-1 mt-md-0 d-flex flex-wrap" style="gap:.5rem;">
            <select name="user_id" id="user_id" class="form-control" style="min-width:200px">
                <option value="all">Semua Karyawan / Cabang</option>
                @foreach ($filter as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" id="filter">
                <i class="feather icon-filter mr-25"></i> Filter
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table display table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="refresh_body">
                @include('modul_admin.transaksi._rows', ['transaksi' => $transaksi])
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
    $('#myTable').DataTable({ order: [[0, 'asc']], pageLength: 25 });
});

$("#filter").click(function () {
    var user_id = $("#user_id").val();
    var $btn = $(this).prop('disabled', true).html('<i class="feather icon-loader"></i>');
    $.get('filter-transaksi', {
        '_token': $('meta[name=csrf-token]').attr('content'),
        user_id: user_id
    }, function (resp) {
        // Reinit DataTable
        if ($.fn.DataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable().destroy();
        }
        $("#refresh_body").html(resp);
        $('#myTable').DataTable({ order: [[0, 'asc']], pageLength: 25 });
    }).always(function () {
        $btn.prop('disabled', false).html('<i class="feather icon-filter mr-25"></i> Filter');
    });
});

function rupiah(n) { return 'Rp ' + (Math.round(n) || 0).toLocaleString('id-ID'); }
$(document).on('click', '.btn-detail-items', function () {
    var items = $(this).data('items') || [];
    var invoice = $(this).data('invoice') || '';
    var $tb = $('#mid-tbody').empty();
    var totKg = 0, totSub = 0;
    items.forEach(function (it, i) {
        totKg += parseFloat(it.kg) || 0;
        totSub += parseInt(it.subtotal) || 0;
        $tb.append(
            '<tr>' +
              '<td>' + (i + 1) + '</td>' +
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
