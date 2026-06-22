@extends('layouts.backend')
@section('title','Profile Admin')
@section('header','Profile')
@section('content')

@php
    $avatar = $profile->foto
        ? asset('storage/images/foto_profile/'.$profile->foto)
        : asset('backend/images/profile/user.jpg');
@endphp

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="feather icon-check-circle mr-50"></i> {{ $message }}
    </div>
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="feather icon-alert-circle mr-50"></i> {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="feather icon-alert-circle mr-50"></i>
        <strong>Ada {{ $errors->count() }} kesalahan:</strong>
        <ul class="mb-0 mt-50">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="row">
    {{-- KIRI: Profile card --}}
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-body text-center pb-1">
                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mb-1"
                     style="width:120px; height:120px; object-fit:cover; border:4px solid rgba(115,103,240,.15);">
                <h4 class="text-bold-700 mb-25">{{ $profile->name }}</h4>
                <span class="badge badge-light-danger mb-50">
                    <i class="feather icon-shield"></i> Administrator
                </span>
            </div>
            <hr class="my-1">
            <div class="card-body pt-1">
                <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">Kontak</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-50 d-flex">
                        <i class="feather icon-mail text-muted mr-50 mt-25"></i>
                        <span class="flex-fill" style="word-break:break-all;">{{ $profile->email ?: '—' }}</span>
                    </li>
                    <li class="mb-50 d-flex">
                        <i class="feather icon-phone text-muted mr-50 mt-25"></i>
                        <span class="flex-fill">{{ $profile->no_telp ?: 'Belum diisi' }}</span>
                    </li>
                    <li class="d-flex">
                        <i class="feather icon-map-pin text-muted mr-50 mt-25"></i>
                        <span class="flex-fill">{{ $profile->alamat ?: 'Belum diisi' }}</span>
                    </li>
                </ul>
            </div>
            <hr class="my-1">
            <div class="card-body pt-1">
                <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">Info Akun</h6>
                <div class="d-flex justify-content-between mb-50">
                    <span class="text-muted">Bergabung</span>
                    <span class="text-bold-600">{{ $profile->created_at?->format('d M Y') ?? '—' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="text-muted">Status</span>
                    <span class="badge badge-light-success">{{ $profile->status ?: 'Active' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- KANAN: Form edit --}}
    <div class="col-lg-8 col-12">
        <form action="{{ route('profile-admin.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-0">
                        <i class="feather icon-user mr-50 text-primary"></i> Data Diri
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold-600">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold-600">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold-600">No. Telp / HP</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', $profile->no_telp) }}" class="form-control" placeholder="08123...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold-600">Foto Profil</label>
                                <input type="file" name="foto" class="form-control-file" accept="image/*">
                                <small class="text-muted">Kosongkan kalau tidak ganti. Max 2MB.</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label class="text-bold-600">Alamat</label>
                                <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $profile->alamat) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-0">
                        <i class="feather icon-lock mr-50 text-warning"></i> Ubah Password
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mb-2">
                        <i class="feather icon-alert-triangle mr-25"></i>
                        Kosongkan kalau tidak ingin ganti password.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-bold-600">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                <small class="text-muted">Minimal 6 karakter.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-bold-600">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap mb-2" style="gap:.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="feather icon-save mr-25"></i> Simpan Perubahan
                </button>
                <a href="{{ url('home') }}" class="btn btn-outline-secondary">
                    <i class="feather icon-x mr-25"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
