@extends('layouts.backend')
@section('title','Karyawan - Data Harga')
@section('header','Data Harga')
@section('content')

@php
    $total  = $hargaList->count();
    $aktif  = $hargaList->where('status', '1')->count();
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <h2 class="text-bold-700 mb-25">Data Harga Laundry</h2>
        <p class="text-muted mb-0">
            Daftar harga laundry untuk cabang kamu. Data ini di-set oleh admin —
            hubungi admin kalau perlu tambah/ubah.
        </p>
    </div>
</div>

{{-- ============ FLASH ============ --}}
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

{{-- ============ STATE: KOSONG ============ --}}
@if ($total == 0)
    <div class="card border-warning" style="border-left: 4px solid var(--warning, #ff9f43);">
        <div class="card-body text-center py-4">
            <div class="mb-2" style="display:inline-flex; align-items:center; justify-content:center; width:72px; height:72px; border-radius:50%; background:rgba(255,159,67,.15);">
                <i class="feather icon-alert-triangle text-warning" style="font-size:2rem"></i>
            </div>
            <h3 class="text-bold-700 mb-50">Belum Ada Data Harga</h3>
            <p class="text-muted mb-2" style="max-width:540px; margin: 0 auto;">
                Kamu belum bisa membuat order karena belum ada data harga untuk cabang kamu.
                Mohon hubungi admin agar mengisi data harga di menu <strong>Finance &raquo; Harga Laundry</strong>.
            </p>
            <div class="d-inline-block text-left p-1 rounded" style="background:rgba(115,103,240,.08); border:1px solid rgba(115,103,240,.2); font-size:.85rem;">
                <strong class="d-block mb-25"><i class="feather icon-info mr-25"></i> Yang perlu admin lakukan:</strong>
                <ol class="mb-0 pl-2 text-muted">
                    <li>Login sebagai Admin</li>
                    <li>Buka menu <em>Data Finance &raquo; Harga Laundry</em></li>
                    <li>Pilih cabang kamu, isi jenis pakaian, harga, dan lama hari</li>
                </ol>
            </div>
        </div>
    </div>
@else

    {{-- ============ STAT CARDS ============ --}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{ $total }}</h2>
                        <p class="mb-0 text-muted">Total Item Harga</p>
                    </div>
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(115,103,240,.15);">
                        <i class="feather icon-tag text-primary" style="font-size:1.2rem"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{ $aktif }}</h2>
                        <p class="mb-0 text-muted">Aktif &amp; Bisa Dipilih</p>
                    </div>
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(40,199,111,.15);">
                        <i class="feather icon-check-circle text-success" style="font-size:1.2rem"></i>
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
                        <h4 class="card-title mb-25">Daftar Harga</h4>
                        <p class="card-text font-small-2 mb-0 text-muted">
                            Mode <strong>read-only</strong> — hanya admin yang bisa edit harga.
                        </p>
                    </div>
                    <div class="mt-1 mt-md-0">
                        <div class="input-group input-group-merge" style="min-width:240px">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="feather icon-search"></i></span>
                            </div>
                            <input type="text" id="harga-search" class="form-control" placeholder="Cari jenis pakaian...">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="harga-table">
                        <thead>
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Jenis Pakaian</th>
                                <th>Lama Pengerjaan</th>
                                <th>Harga / Kg</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hargaList as $no => $item)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>
                                        <span class="text-bold-600">{{ $item->jenis }}</span><br>
                                        <small class="text-muted">{{ $item->kg }} gram / kg</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info">
                                            <i class="feather icon-clock"></i> {{ $item->hari }} hari
                                        </span>
                                    </td>
                                    <td class="text-bold-600">{{ Rupiah::getRupiah($item->harga) }}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <span class="badge badge-light-success">
                                                <i class="feather icon-check"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-light-secondary">
                                                <i class="feather icon-pause"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body py-1 border-top">
                    <small class="text-muted">Menampilkan {{ $total }} item harga</small>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
<script>
$(document).on('input', '#harga-search', function() {
    var q = $(this).val().toLowerCase().trim();
    var visible = 0;
    $('#harga-table tbody tr').each(function() {
        var text = $(this).text().toLowerCase();
        var show = !q || text.indexOf(q) !== -1;
        $(this).toggle(show);
        if (show) visible++;
    });
    $('#no-match').remove();
    if (visible === 0 && q) {
        $('#harga-table tbody').append(
            '<tr id="no-match"><td colspan="5" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada item cocok dengan "' + q + '"</td></tr>'
        );
    }
});
</script>
@endsection
