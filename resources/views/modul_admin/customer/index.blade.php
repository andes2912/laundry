@extends('layouts.backend')
@section('title','Admin - Data Customer')
@section('header','Data Customer')
@section('content')

@php
    $total = $customer->count();
    $laki  = $customer->where('kelamin','L')->count();
    $perem = $total - $laki;
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Data Customer</h2>
        <p class="text-muted mb-0">
            Semua customer yang pernah bertransaksi tersimpan di sini. Klik <em>Info</em> untuk lihat detail transaksi.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <span class="badge badge-light-primary p-50" style="font-size:.85rem">
            <i class="feather icon-users mr-25"></i> {{ $total }} Customer Terdaftar
        </span>
    </div>
</div>

{{-- ============ FLASH ============ --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-check-circle mr-50"></i> {{ $message }}
    </div>
@endif

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $total }}</h2>
                    <p class="mb-0 text-muted">Total Customer</p>
                </div>
                <div class="avatar bg-rgba-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-users text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $laki }}</h2>
                    <p class="mb-0 text-muted">Laki-laki</p>
                </div>
                <div class="avatar bg-rgba-info p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-user text-info font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $perem }}</h2>
                    <p class="mb-0 text-muted">Perempuan</p>
                </div>
                <div class="avatar bg-rgba-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-user text-warning font-medium-5"></i>
                    </div>
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
                    <h4 class="card-title mb-25">Daftar Customer</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">
                        Total {{ $total }} customer terdaftar
                    </p>
                </div>
                <div class="mt-1 mt-md-0">
                    <div class="input-group input-group-merge" style="min-width: 240px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                        </div>
                        <input type="text" id="cust-search" class="form-control" placeholder="Cari nama, alamat, no.telp...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="cust-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Customer</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Kelamin</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer as $no => $item)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <div class="media align-items-center">
                                        @php
                                            $foto = $item->foto
                                                ? asset('storage/images/foto_profile/'.$item->foto)
                                                : asset('backend/images/profile/user.jpg');
                                        @endphp
                                        <img src="{{ $foto }}" alt="{{ $item->name }}" class="round mr-1" width="40" height="40">
                                        <div class="media-body">
                                            <h6 class="mb-0 text-bold-600">{{ $item->name }}</h6>
                                            <small class="text-muted">{{ $item->email ?: '—' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="feather icon-map-pin mr-25 text-muted"></i>
                                    <span class="text-muted">{{ $item->alamat ?: '—' }}</span>
                                </td>
                                <td>
                                    <i class="feather icon-phone mr-25 text-muted"></i>
                                    {{ $item->no_telp ?: '—' }}
                                </td>
                                <td>
                                    @if ($item->kelamin == 'L')
                                        <span class="badge badge-light-info">
                                            <i class="feather icon-user"></i> Laki-laki
                                        </span>
                                    @else
                                        <span class="badge badge-light-warning">
                                            <i class="feather icon-user"></i> Perempuan
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('customer.show', $item->id) }}"
                                       class="btn btn-sm btn-flat-primary"
                                       title="Lihat detail transaksi">
                                        <i class="feather icon-eye"></i> Info
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="feather icon-inbox font-medium-5 d-block mb-1"></i>
                                    Belum ada customer terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body py-1 border-top">
                <small class="text-muted">Menampilkan {{ $total }} customer</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// ===== Live search filter (tanpa DataTables) =====
$(document).on('input', '#cust-search', function() {
    var q = $(this).val().toLowerCase().trim();
    var visible = 0;
    $('#cust-table tbody tr').each(function() {
        if ($(this).attr('id') === 'empty-row') return;
        var text = $(this).text().toLowerCase();
        var show = !q || text.indexOf(q) !== -1;
        $(this).toggle(show);
        if (show) visible++;
    });
    $('#no-match').remove();
    if (visible === 0 && q) {
        $('#cust-table tbody').append(
            '<tr id="no-match"><td colspan="6" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada customer cocok dengan "' + q + '"</td></tr>'
        );
    }
});
</script>
@endsection
