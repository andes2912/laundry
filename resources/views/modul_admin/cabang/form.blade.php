@extends('layouts.backend')
@section('title', $mode === 'edit' ? 'Edit Cabang' : 'Tambah Cabang')
@section('header', $mode === 'edit' ? 'Edit Cabang' : 'Tambah Cabang')
@section('content')

@php
    $isEdit  = $mode === 'edit';
    $action  = $isEdit ? route('cabang.update', $cabang->id) : route('cabang.store');
    $heading = $isEdit ? 'Edit Cabang' : 'Tambah Cabang Baru';
    $sub     = $isEdit
        ? 'Perbarui detail cabang. Perubahan langsung berlaku.'
        : 'Buat cabang baru. Setelah dibuat, kamu bisa menambahkan karyawan ke cabang ini.';
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('home') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cabang.index') }}" class="text-muted">Cabang</a></li>
                <li class="breadcrumb-item active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
        <h2 class="text-bold-700 mb-25">{{ $heading }}</h2>
        <p class="text-muted mb-0">{{ $sub }}</p>
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

<form action="{{ $action }}" method="POST" id="cabang-form">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-map-pin mr-50 text-primary"></i> Detail Cabang
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">Informasi dasar cabang.</p>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="form-group">
                        <label for="nama">Nama Cabang <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="feather icon-tag"></i></span>
                            </div>
                            <input type="text" name="nama" id="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Misal: Cabang Tebet"
                                   value="{{ old('nama', $cabang->nama) }}" required>
                        </div>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap cabang" required>{{ old('alamat', $cabang->alamat) }}</textarea>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label for="no_telp">No. Telp / WhatsApp</label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="feather icon-phone"></i></span>
                            </div>
                            <input type="text" name="no_telp" id="no_telp"
                                   class="form-control @error('no_telp') is-invalid @enderror"
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('no_telp', $cabang->no_telp) }}">
                        </div>
                        <small class="text-muted">Opsional. Akan ditampilkan di invoice.</small>
                        @error('no_telp')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-settings mr-50 text-warning"></i> Status Cabang
                        </h4>
                    </div>
                </div>
                <div class="card-body pt-2">
                    @php $currentStatus = old('status', $cabang->status ?? 'Active'); @endphp
                    <div class="form-group mb-0">
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="status-active" name="status" value="Active"
                                   class="custom-control-input" {{ $currentStatus === 'Active' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="status-active">
                                <strong class="text-success">Aktif</strong><br>
                                <small class="text-muted">Cabang aktif & bisa dipilih saat tambah karyawan.</small>
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status-nonactive" name="status" value="Not Active"
                                   class="custom-control-input" {{ $currentStatus === 'Not Active' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="status-nonactive">
                                <strong class="text-danger">Tidak Aktif</strong><br>
                                <small class="text-muted">Disembunyikan dari dropdown form karyawan.</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block mb-50">
                        <i class="feather icon-check mr-25"></i>
                        {{ $isEdit ? 'Update Cabang' : 'Simpan Cabang' }}
                    </button>
                    <a href="{{ route('cabang.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="feather icon-x mr-25"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
