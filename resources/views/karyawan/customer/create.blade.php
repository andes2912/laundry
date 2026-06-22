@extends('layouts.backend')
@section('title','Tambah Customer')
@section('header','Tambah Customer')
@section('content')

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('home') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('customers') }}" class="text-muted">Customer</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
        <h2 class="text-bold-700 mb-25">Tambah Customer Baru</h2>
        <p class="text-muted mb-0">
            Isi data customer di bawah. Password akan dibuat otomatis dan dikirim ke email customer
            (jika notifikasi email aktif).
        </p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i>
        <strong>Ada {{ $errors->count() }} kesalahan:</strong>
        <ul class="mb-0 mt-50">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('customers-store') }}" method="POST" id="cust-form">
    @csrf

    <div class="row">
        {{-- ============ KIRI: DATA CUSTOMER ============ --}}
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-user mr-50 text-primary"></i> Data Customer
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">Informasi dasar customer.</p>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-user"></i></span>
                                    </div>
                                    <input type="text" name="name" id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Misal: Siti Aminah"
                                           value="{{ old('name') }}" required autocomplete="off">
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="email@customer.com"
                                           value="{{ old('email') }}" required autocomplete="off">
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="no_telp">No. WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-message-circle"></i></span>
                                    </div>
                                    <input type="number" name="no_telp" id="no_telp"
                                           class="form-control @error('no_telp') is-invalid @enderror"
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('no_telp') }}" required autocomplete="off">
                                </div>
                                <small class="text-muted">
                                    <i class="feather icon-info mr-25"></i>
                                    Awalan 0 akan otomatis diubah menjadi 62. Nomor ini akan dipakai untuk notifikasi status laundry.
                                </small>
                                @error('no_telp')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" rows="3"
                                          class="form-control @error('alamat') is-invalid @enderror"
                                          placeholder="Alamat customer (untuk antar-jemput jika ada)" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KANAN: INFO + ACTIONS ============ --}}
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-info mr-50 text-info"></i> Yang Perlu Diketahui
                        </h4>
                    </div>
                </div>
                <div class="card-body pt-2">
                    @php
                        $iconWrap = 'display:inline-flex; align-items:center; justify-content:center;'
                                  . 'width:40px; height:40px; min-width:40px; border-radius:50%;'
                                  . 'flex-shrink:0; margin-right:.85rem; line-height:1;';
                        $iconStyle = 'font-size:1.1rem; line-height:1;';
                    @endphp
                    <div class="d-flex mb-1 align-items-start">
                        <span style="{{ $iconWrap }} background: rgba(40,199,111,.15);">
                            <i class="feather icon-lock text-success" style="{{ $iconStyle }}"></i>
                        </span>
                        <div>
                            <h6 class="mb-0 text-bold-600">Password Otomatis</h6>
                            <small class="text-muted">Password 8 karakter random akan dibuat otomatis.</small>
                        </div>
                    </div>
                    <div class="d-flex mb-1 align-items-start">
                        <span style="{{ $iconWrap }} background: rgba(0,207,232,.15);">
                            <i class="feather icon-mail text-info" style="{{ $iconStyle }}"></i>
                        </span>
                        <div>
                            <h6 class="mb-0 text-bold-600">Email Welcome</h6>
                            <small class="text-muted">
                                Dikirim otomatis jika SMTP & notifikasi email aktif.
                                Kalau belum dikonfigurasi, password akan ditampilkan di layar
                                supaya bisa dikirim manual via WhatsApp.
                            </small>
                        </div>
                    </div>
                    <div class="d-flex mb-0 align-items-start">
                        <span style="{{ $iconWrap }} background: rgba(255,159,67,.15);">
                            <i class="feather icon-link text-warning" style="{{ $iconStyle }}"></i>
                        </span>
                        <div>
                            <h6 class="mb-0 text-bold-600">Otomatis Terhubung</h6>
                            <small class="text-muted">Customer akan tercatat di bawah akun karyawan kamu ({{ Auth::user()->name }}).</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block mb-50">
                        <i class="feather icon-check mr-25"></i> Simpan Customer
                    </button>
                    <a href="{{ url('customers') }}" class="btn btn-outline-secondary btn-block">
                        <i class="feather icon-x mr-25"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
// Confirm before leaving with unsaved changes
var formDirty = false;
$('#cust-form :input').on('change input', function() { formDirty = true; });
$('#cust-form').on('submit', function() { formDirty = false; });
window.addEventListener('beforeunload', function(e) {
    if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});
</script>
@endsection
