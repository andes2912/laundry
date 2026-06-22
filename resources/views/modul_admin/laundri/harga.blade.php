@extends('layouts.backend')
@section('title','Admin - Data Harga Laundry')
@section('content')

@php
    $totalHarga  = $harga->count();
    $aktifHarga  = $harga->where('status', '1')->count();
    $cabangCount = $harga->pluck('user_id')->unique()->count();
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Data Harga Laundry</h2>
        <p class="text-muted mb-0">
            Atur harga per jenis pakaian untuk tiap cabang. Karyawan akan pakai data ini saat input order.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <span class="badge badge-light-primary p-50" style="font-size:.85rem">
            <i class="feather icon-tag mr-25"></i> {{ $totalHarga }} Item Harga
        </span>
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

{{-- ============ GUARD: DATA BANK ============ --}}
@if ($getBank == 0)
    <div class="card border-warning" style="border-left: 4px solid var(--warning, #ff9f43);">
        <div class="card-body text-center py-4">
            <div class="mb-2" style="display:inline-flex; align-items:center; justify-content:center; width:72px; height:72px; border-radius:50%; background:rgba(255,159,67,.15);">
                <i class="feather icon-alert-triangle text-warning" style="font-size:2rem"></i>
            </div>
            <h3 class="text-bold-700 mb-50">Data Bank Belum Dikonfigurasi</h3>
            <p class="text-muted mb-2" style="max-width:520px; margin: 0 auto;">
                Sebelum mengisi data harga, atur dulu data bank di halaman Pengaturan.
                Data bank ini akan dicantumkan di invoice & email customer.
            </p>
            <a href="{{ url('settings') }}" class="btn btn-primary">
                <i class="feather icon-settings mr-25"></i> Pergi ke Pengaturan
            </a>
        </div>
    </div>
@else

    {{-- ============ STAT CARDS ============ --}}
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{ $totalHarga }}</h2>
                        <p class="mb-0 text-muted">Total Item Harga</p>
                    </div>
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(115,103,240,.15);">
                        <i class="feather icon-tag text-primary" style="font-size:1.2rem"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{ $aktifHarga }}</h2>
                        <p class="mb-0 text-muted">Harga Aktif</p>
                    </div>
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(40,199,111,.15);">
                        <i class="feather icon-check-circle text-success" style="font-size:1.2rem"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{ $cabangCount }}</h2>
                        <p class="mb-0 text-muted">Cabang Terlayani</p>
                    </div>
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:rgba(0,207,232,.15);">
                        <i class="feather icon-map-pin text-info" style="font-size:1.2rem"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ============ KIRI: LIST HARGA ============ --}}
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header border-bottom flex-column flex-md-row align-items-md-center">
                    <div>
                        <h4 class="card-title mb-25">Daftar Harga</h4>
                        <p class="card-text font-small-2 mb-0 text-muted">
                            Klik <strong>Edit</strong> untuk ubah jenis, harga, lama, atau status.
                        </p>
                    </div>
                    <div class="mt-1 mt-md-0">
                        <div class="input-group input-group-merge" style="min-width:240px">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="feather icon-search"></i></span>
                            </div>
                            <input type="text" id="harga-search" class="form-control" placeholder="Cari jenis, cabang...">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="harga-table">
                        <thead>
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Jenis Pakaian</th>
                                <th>Cabang</th>
                                <th>Lama</th>
                                <th>Harga / Kg</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($harga as $no => $item)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>
                                        <span class="text-bold-600">{{ $item->jenis }}</span><br>
                                        <small class="text-muted">{{ $item->kg }} gram / kg</small>
                                    </td>
                                    <td>
                                        <i class="feather icon-map-pin mr-25 text-muted"></i>
                                        {{ optional($item->harga_user)->nama_cabang ?? '—' }}
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
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-flat-primary"
                                                data-toggle="modal" data-target="#edit_harga"
                                                data-id="{{ $item->id }}"
                                                data-jenis="{{ $item->jenis }}"
                                                data-kg="{{ $item->kg }}"
                                                data-harga="{{ $item->harga }}"
                                                data-hari="{{ $item->hari }}"
                                                data-status="{{ $item->status }}"
                                                id="click_harga">
                                            <i class="feather icon-edit-2"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-row">
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="feather icon-tag font-medium-5 d-block mb-1"></i>
                                        Belum ada data harga.<br>
                                        Isi form di sebelah kanan untuk menambah harga pertama.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-body py-1 border-top">
                    <small class="text-muted">Menampilkan {{ $totalHarga }} item harga</small>
                </div>
            </div>
        </div>

        {{-- ============ KANAN: FORM TAMBAH ============ --}}
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-plus-circle mr-50 text-primary"></i> Tambah Harga
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">
                            Pilih cabang, isi jenis, harga & lama hari.
                        </p>
                    </div>
                </div>
                <div class="card-body pt-2">
                    @if ($karyawan == !null)
                        <form action="{{ url('harga-store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cabang-select">Cabang <span class="text-danger">*</span></label>
                                <select name="user_id" id="cabang-select"
                                        class="form-control @error('user_id') is-invalid @enderror" required>
                                    <option value="">— Pilih Cabang —</option>
                                    @foreach ($getcabang as $item)
                                        <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_cabang }} · {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis-input">Jenis Pakaian <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-tag"></i></span>
                                    </div>
                                    <input type="text" name="jenis" id="jenis-input" value="{{ old('jenis') }}"
                                           class="form-control @error('jenis') is-invalid @enderror"
                                           placeholder="Misal: Baju + Celana" autocomplete="off" required>
                                </div>
                                <small class="text-muted">Pisahkan dengan tanda <code>+</code> jika lebih dari satu.</small>
                                @error('jenis')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Berat Per-Kg</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-package"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="1000 gram" readonly>
                                </div>
                                <small class="text-muted">Fixed 1000 gram = 1 kg.</small>
                            </div>

                            <div class="form-group">
                                <label for="harga-input">Harga Per-Kg <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="harga" id="harga-input" value="{{ old('harga') }}"
                                           class="form-control format_harga @error('harga') is-invalid @enderror"
                                           placeholder="7000" autocomplete="off" required>
                                </div>
                                <small class="text-muted">Boleh pakai titik/koma; akan dirapikan otomatis.</small>
                                @error('harga')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="hari-input">Lama (Hari) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                    </div>
                                    <input type="number" min="1" name="hari" id="hari-input" value="{{ old('hari') }}"
                                           class="form-control @error('hari') is-invalid @enderror"
                                           placeholder="Misal: 2" required>
                                </div>
                                @error('hari')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block mb-50">
                                <i class="feather icon-check mr-25"></i> Simpan Harga
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-block">
                                <i class="feather icon-rotate-ccw mr-25"></i> Reset
                            </button>
                        </form>
                    @else
                        <div class="text-center py-3">
                            <div class="mb-2" style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; border-radius:50%; background:rgba(234,84,85,.15);">
                                <i class="feather icon-alert-octagon text-danger" style="font-size:1.8rem"></i>
                            </div>
                            <h5 class="text-bold-700 mb-50">Belum Ada Karyawan</h5>
                            <p class="text-muted mb-2">Sebelum buat harga, harus ada minimal 1 karyawan/cabang aktif.</p>
                            <a href="{{ route('karyawan.index') }}" class="btn btn-primary btn-block">
                                <i class="feather icon-user-plus mr-25"></i> Tambah Karyawan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('modul_admin.laundri.editharga')

@endif

@endsection

@section('scripts')
<script type="text/javascript">
// Format harga input — strip non-digit while typing
$(document).on('input', '#harga-input', function() {
    var v = $(this).val().replace(/\D/g, '');
    if (v) $(this).val(parseInt(v, 10).toLocaleString('id-ID'));
});

// Search live filter
$(document).on('input', '#harga-search', function() {
    var q = $(this).val().toLowerCase().trim();
    var visible = 0;
    $('#harga-table tbody tr').each(function() {
        if ($(this).attr('id') === 'empty-row') return;
        var text = $(this).text().toLowerCase();
        var show = !q || text.indexOf(q) !== -1;
        $(this).toggle(show);
        if (show) visible++;
    });
    $('#no-match').remove();
    if (visible === 0 && q) {
        $('#harga-table tbody').append(
            '<tr id="no-match"><td colspan="7" class="text-center py-3 text-muted">' +
            '<i class="feather icon-search"></i> Tidak ada harga cocok dengan "' + q + '"</td></tr>'
        );
    }
});

// Modal Edit Harga — populate fields
$(document).on('click', '#click_harga', function() {
    $("#id_harga").val($(this).data('id'));
    $("#jenis").val($(this).data('jenis'));
    $("#kg").val($(this).data('kg'));
    $("#hari").val($(this).data('hari'));
    $("#harga").val($(this).data('harga'));
    $("#status").val($(this).data('status'));
});

// Proses simpan edit harga via AJAX
$(document).on('click', '#simpan_harga', function() {
    var data = {
        '_token':   $('meta[name=csrf-token]').attr('content'),
        id_harga:   $("#id_harga").val(),
        jenis:      $("#jenis").val(),
        kg:         $("#kg").val(),
        hari:       $("#hari").val(),
        harga:      $("#harga").val(),
        status:     $("#status").val(),
    };
    $.get('{{ Url("edit-harga") }}', data, function() {
        location.reload();
    });
});
</script>
@endsection
