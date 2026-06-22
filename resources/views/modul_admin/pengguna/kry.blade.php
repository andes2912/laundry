@extends('layouts.backend')
@section('title','Admin - Data Karyawan')
@section('header','Data Karyawan')
@section('content')

@php
    $totalKry  = $kry->count();
    $aktifKry  = $kry->where('status','Active')->count();
    $nonaktif  = $totalKry - $aktifKry;
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Data Karyawan / Cabang</h2>
        <p class="text-muted mb-0">
            Kelola data karyawan dan cabang laundry kamu. Aktifkan / non-aktifkan akun karyawan kapan saja.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
            <i class="feather icon-user-plus mr-25"></i> Tambah Karyawan
        </a>
    </div>
</div>

{{-- ============ FLASH MESSAGE ============ --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="feather icon-check-circle mr-50"></i> {{ $message }}
    </div>
@elseif($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $totalKry }}</h2>
                    <p class="mb-0 text-muted">Total Karyawan</p>
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
                    <h2 class="text-bold-700 mb-0">{{ $aktifKry }}</h2>
                    <p class="mb-0 text-muted">Karyawan Aktif</p>
                </div>
                <div class="avatar bg-rgba-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-user-check text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $nonaktif }}</h2>
                    <p class="mb-0 text-muted">Non-Aktif</p>
                </div>
                <div class="avatar bg-rgba-danger p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-user-x text-danger font-medium-5"></i>
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
                    <h4 class="card-title mb-25">Daftar Karyawan</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">
                        Total {{ $totalKry }} karyawan terdaftar
                    </p>
                </div>
                <div class="mt-1 mt-md-0">
                    <div class="input-group input-group-merge" style="min-width: 240px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                        </div>
                        <input type="text" id="kry-search" class="form-control" placeholder="Cari nama, email, cabang...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="kry-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Karyawan</th>
                            <th>Cabang</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kry as $no => $item)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <div class="media align-items-center">
                                        @php
                                            $foto = $item->foto ? asset('storage/images/foto_profile/'.$item->foto) : asset('backend/images/profile/user.jpg');
                                        @endphp
                                        <img src="{{ $foto }}" alt="{{ $item->name }}" class="round mr-1" width="40" height="40">
                                        <div class="media-body">
                                            <h6 class="mb-0 text-bold-600">{{ $item->name }}</h6>
                                            <small class="text-muted">{{ $item->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->cabang)
                                        <a href="{{ route('cabang.edit', $item->cabang->id) }}" class="d-block text-bold-600">
                                            {{ $item->cabang->nama }}
                                        </a>
                                        <small class="text-muted">{{ $item->cabang->alamat ?: '—' }}</small>
                                    @else
                                        {{-- fallback ke data lama kalau cabang_id belum di-backfill --}}
                                        <span class="d-block text-bold-600 text-muted">{{ $item->nama_cabang ?: '—' }}</span>
                                        @if($item->nama_cabang)
                                            <small class="badge badge-light-warning">Belum dipindah ke tabel cabang</small>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <i class="feather icon-phone mr-25 text-muted"></i>
                                    {{ $item->no_telp ?: '-' }}
                                </td>
                                <td>
                                    @if ($item->status == 'Active')
                                        <span class="badge badge-light-success">
                                            <i class="feather icon-check"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-light-danger">
                                            <i class="feather icon-x"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <button
                                        class="btn btn-sm btn-{{ $item->status == 'Active' ? 'flat-warning' : 'flat-success' }}"
                                        data-id-update="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-status="{{ $item->status }}"
                                        id="updateStatus"
                                        title="{{ $item->status == 'Active' ? 'Non-aktifkan akun' : 'Aktifkan akun' }}">
                                        <i class="feather icon-{{ $item->status == 'Active' ? 'user-x' : 'user-check' }}"></i>
                                        {{ $item->status == 'Active' ? 'Non-Aktifkan' : 'Aktifkan' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="feather icon-inbox font-medium-5 d-block mb-1"></i>
                                    Belum ada karyawan. Klik tombol <strong>Tambah Karyawan</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body py-1 border-top">
                <small class="text-muted">Menampilkan {{ $totalKry }} karyawan</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// ===== Update Status Karyawan =====
$(document).on('click', '#updateStatus', function () {
    var id     = $(this).attr('data-id-update');
    var name   = $(this).attr('data-name');
    var status = $(this).attr('data-status');
    var msg    = status === 'Active'
                ? 'Yakin ingin menon-aktifkan akun ' + name + '?'
                : 'Aktifkan kembali akun ' + name + '?';

    if (!confirm(msg)) return;

    $.get('update-satatus-karyawan',
        {'_token' : $('meta[name=csrf-token]').attr('content'), id: id},
        function(_resp){ location.reload(); }
    );
});

// ===== Live search filter =====
$(document).on('input', '#kry-search', function() {
    var q = $(this).val().toLowerCase().trim();
    var visible = 0;
    $('#kry-table tbody tr').each(function() {
        if ($(this).attr('id') === 'empty-row') return;
        var text = $(this).text().toLowerCase();
        var show = !q || text.indexOf(q) !== -1;
        $(this).toggle(show);
        if (show) visible++;
    });
    // No-match placeholder
    $('#no-match').remove();
    if (visible === 0 && q) {
        $('#kry-table tbody').append(
            '<tr id="no-match"><td colspan="6" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada karyawan cocok dengan "' + q + '"</td></tr>'
        );
    }
});
</script>
@endsection
