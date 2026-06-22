@extends('layouts.backend')
@section('title','Form Tambah Data Karyawan')
@section('header','Tambah Karyawan')
@section('content')

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb breadcrumb-slash" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('home') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}" class="text-muted">Karyawan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
        <h2 class="text-bold-700 mb-25">Tambah Karyawan Baru</h2>
        <p class="text-muted mb-0">
            Isi data berikut untuk membuat akun karyawan baru. Karyawan akan otomatis mendapat role <strong>Karyawan</strong>.
        </p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="feather icon-alert-circle mr-50"></i>
        <strong>Ada {{ $errors->count() }} kesalahan pada form:</strong>
        <ul class="mb-0 mt-50">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('karyawan.store') }}" method="POST" class="form form-vertical" id="kry-form">
    @csrf
    <div class="row">

        {{-- ============ KIRI: AKUN + PROFILE ============ --}}
        <div class="col-lg-8 col-12">

            {{-- Section 1: Akun --}}
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-lock mr-50 text-primary"></i> Akun Login
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">Detail login karyawan ke sistem.</p>
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
                                           placeholder="Misal: Budi Santoso"
                                           value="{{ old('name') }}" required>
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
                                           placeholder="email@laundry.com"
                                           value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimum 6 karakter" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-flat-primary toggle-pass" data-target="password" tabindex="-1">
                                            <i class="feather icon-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="confirm-password">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-check"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" id="confirm-password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Ulangi password" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-flat-primary toggle-pass" data-target="confirm-password" tabindex="-1">
                                            <i class="feather icon-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Profile --}}
            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-user mr-50 text-info"></i> Profile Karyawan
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">Data kontak personal karyawan.</p>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="no_telp">No. Telp / WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-phone"></i></span>
                                    </div>
                                    <input type="number" name="no_telp" id="no_telp"
                                           class="form-control @error('no_telp') is-invalid @enderror"
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('no_telp') }}" required>
                                </div>
                                <small class="text-muted">Awalan 0 akan otomatis diubah jadi 62.</small>
                                @error('no_telp')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label for="alamat">Alamat Karyawan</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                          class="form-control @error('alamat') is-invalid @enderror"
                                          placeholder="Alamat tempat tinggal karyawan">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KANAN: CABANG + ACTIONS ============ --}}
        <div class="col-lg-4 col-12">

            <div class="card">
                <div class="card-header border-bottom">
                    <div>
                        <h4 class="card-title mb-25">
                            <i class="feather icon-map-pin mr-50 text-warning"></i> Pilih Cabang
                        </h4>
                        <p class="card-text font-small-2 mb-0 text-muted">
                            Cabang tempat karyawan ini bekerja.
                        </p>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="form-group">
                        <label for="cabang_id">Cabang <span class="text-danger">*</span></label>
                        <select name="cabang_id" id="cabang_id"
                                class="form-control @error('cabang_id') is-invalid @enderror" required>
                            <option value="">— Pilih Cabang —</option>
                            @foreach ($cabangs as $c)
                                <option value="{{ $c->id }}"
                                        data-alamat="{{ $c->alamat }}"
                                        {{ old('cabang_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('cabang_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div id="cabang-preview" class="p-1 rounded mb-0" style="background: rgba(115,103,240,.08); border:1px solid rgba(115,103,240,.2); display:none;">
                        <small class="d-block text-muted mb-25">
                            <i class="feather icon-map-pin mr-25"></i> Alamat cabang:
                        </small>
                        <small id="cabang-alamat" class="d-block">—</small>
                    </div>
                    <small class="text-muted d-block mt-1">
                        Cabang belum ada? <a href="{{ route('cabang.create') }}">Buat cabang dulu</a>.
                    </small>
                </div>
            </div>

            {{-- Action card --}}
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block mb-50">
                        <i class="feather icon-check mr-25"></i> Simpan Karyawan
                    </button>
                    <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="feather icon-x mr-25"></i> Batal
                    </a>
                    <hr>
                    <small class="text-muted d-block">
                        <i class="feather icon-info mr-25"></i>
                        Karyawan baru otomatis berstatus <strong class="text-success">Aktif</strong>
                        dan diberi role <strong>Karyawan</strong>.
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
// Toggle show/hide password
$(document).on('click', '.toggle-pass', function() {
    var target = $(this).data('target');
    var $input = $('#' + target);
    var $icon  = $(this).find('i');
    if ($input.attr('type') === 'password') {
        $input.attr('type', 'text');
        $icon.removeClass('icon-eye').addClass('icon-eye-off');
    } else {
        $input.attr('type', 'password');
        $icon.removeClass('icon-eye-off').addClass('icon-eye');
    }
});

// Confirm before leaving with unsaved changes
var formDirty = false;
$('#kry-form :input').on('change input', function() { formDirty = true; });
$('#kry-form').on('submit', function() { formDirty = false; });
window.addEventListener('beforeunload', function(e) {
    if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});

// Preview alamat cabang saat dipilih
function updateCabangPreview() {
    var $sel = $('#cabang_id');
    var alamat = $sel.find('option:selected').data('alamat');
    if (alamat) {
        $('#cabang-alamat').text(alamat);
        $('#cabang-preview').show();
    } else {
        $('#cabang-preview').hide();
    }
}
$(document).on('change', '#cabang_id', updateCabangPreview);
$(updateCabangPreview);
</script>
@endsection
