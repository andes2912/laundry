@extends('layouts.backend')
@section('title','Admin - Data Cabang')
@section('header','Data Cabang')
@section('content')

@php
    $total  = $cabangs->count();
    $aktif  = $cabangs->where('status','Active')->count();
    $nonAkt = $total - $aktif;
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Data Cabang</h2>
        <p class="text-muted mb-0">
            Kelola cabang laundry kamu. Karyawan yang ditambahkan akan dipasangkan ke salah satu cabang di sini.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ route('cabang.create') }}" class="btn btn-primary">
            <i class="feather icon-plus mr-25"></i> Tambah Cabang
        </a>
    </div>
</div>

{{-- ============ FLASH ============ --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-check-circle mr-50"></i> {{ $message }}
    </div>
@elseif($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $total }}</h2>
                    <p class="mb-0 text-muted">Total Cabang</p>
                </div>
                <div class="avatar bg-rgba-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-map-pin text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $aktif }}</h2>
                    <p class="mb-0 text-muted">Cabang Aktif</p>
                </div>
                <div class="avatar bg-rgba-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-check-circle text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $nonAkt }}</h2>
                    <p class="mb-0 text-muted">Non-Aktif</p>
                </div>
                <div class="avatar bg-rgba-danger p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-x-circle text-danger font-medium-5"></i>
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
                    <h4 class="card-title mb-25">Daftar Cabang</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">
                        Total {{ $total }} cabang terdaftar
                    </p>
                </div>
                <div class="mt-1 mt-md-0">
                    <div class="input-group input-group-merge" style="min-width: 240px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                        </div>
                        <input type="text" id="cabang-search" class="form-control" placeholder="Cari nama, alamat...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="cabang-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Cabang</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Karyawan</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cabangs as $no => $c)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <div class="media align-items-center">
                                        <div class="avatar bg-rgba-primary mr-1 m-0 flex-shrink-0" style="width:40px; height:40px;">
                                            <div class="avatar-content">
                                                <i class="feather icon-map-pin text-primary font-medium-1"></i>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-0 text-bold-600">{{ $c->nama }}</h6>
                                            <small class="text-muted">ID #{{ $c->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $c->alamat ?: '—' }}</span>
                                </td>
                                <td>
                                    @if ($c->no_telp)
                                        <i class="feather icon-phone mr-25 text-muted"></i> {{ $c->no_telp }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light-info">
                                        <i class="feather icon-users"></i> {{ $c->karyawan_count }} orang
                                    </span>
                                </td>
                                <td>
                                    @if ($c->status === 'Active')
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
                                    <a href="{{ route('cabang.edit', $c->id) }}"
                                       class="btn btn-sm btn-flat-primary"
                                       title="Edit cabang">
                                        <i class="feather icon-edit-2"></i>
                                    </a>
                                    <form action="{{ route('cabang.destroy', $c->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-flat-danger"
                                                title="Hapus cabang"
                                                onclick="return confirm('Yakin ingin hapus cabang {{ $c->nama }}?');"
                                                {{ $c->karyawan_count > 0 ? 'disabled title="Masih ada karyawan terkait"' : '' }}>
                                            <i class="feather icon-trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="feather icon-map-pin font-medium-5 d-block mb-1"></i>
                                    Belum ada cabang. Klik <strong>Tambah Cabang</strong> untuk buat pertama.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body py-1 border-top">
                <small class="text-muted">Menampilkan {{ $total }} cabang</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).on('input', '#cabang-search', function() {
    var q = $(this).val().toLowerCase().trim();
    var visible = 0;
    $('#cabang-table tbody tr').each(function() {
        if ($(this).attr('id') === 'empty-row') return;
        var text = $(this).text().toLowerCase();
        var show = !q || text.indexOf(q) !== -1;
        $(this).toggle(show);
        if (show) visible++;
    });
    $('#no-match').remove();
    if (visible === 0 && q) {
        $('#cabang-table tbody').append(
            '<tr id="no-match"><td colspan="7" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada cabang cocok dengan "' + q + '"</td></tr>'
        );
    }
});
</script>
@endsection
