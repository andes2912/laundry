@extends('layouts.backend')
@section('title','Admin - Settings')
@section('header','Settings')
@section('content')

{{-- ============ FLASH ============ --}}
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

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <h2 class="text-bold-700 mb-25">Settings</h2>
        <p class="text-muted mb-0">Atur identitas website, target, tema, akun bank & notifikasi.</p>
    </div>
</div>

<div class="row">
    {{-- ============ HORIZONTAL TAB NAV ============ --}}
    <div class="col-12 mb-1">
        <div class="card mb-0">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-justified mb-0" role="tablist" style="border-bottom: none;">
                    <li class="nav-item">
                        <a class="nav-link active py-1" id="pill-general" data-toggle="tab" href="#vertical-general" role="tab">
                            <i class="feather icon-globe mr-25"></i> <span class="d-none d-sm-inline">General</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1" id="pill-target" data-toggle="tab" href="#vertical-target" role="tab">
                            <i class="feather icon-target mr-25"></i> <span class="d-none d-sm-inline">Target</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1" id="pill-theme" data-toggle="tab" href="#vertical-theme" role="tab">
                            <i class="feather icon-moon mr-25"></i> <span class="d-none d-sm-inline">Tema</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1" id="pill-bank" data-toggle="tab" href="#vertical-bank" role="tab">
                            <i class="feather icon-credit-card mr-25"></i> <span class="d-none d-sm-inline">Bank</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1" id="pill-notif" data-toggle="tab" href="#vertical-notif" role="tab">
                            <i class="feather icon-bell mr-25"></i> <span class="d-none d-sm-inline">Notifikasi</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ============ TAB CONTENT ============ --}}
    <div class="col-12">
        <div class="tab-content">

            {{-- ===== GENERAL ===== --}}
            <div class="tab-pane fade show active" id="vertical-general" role="tabpanel">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div>
                            <h4 class="card-title mb-25">
                                <i class="feather icon-globe mr-50 text-primary"></i> Identitas Website
                            </h4>
                            <small class="text-muted">Info publik yang tampil di landing page & invoice.</small>
                        </div>
                    </div>
                    <form action="{{ route('seting-page.update', $setpage->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="judul">Judul Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" value="{{ $setpage->judul }}" placeholder="E-Laundry" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tentang">Tentang</label>
                                        <textarea name="tentang" class="form-control" rows="3" placeholder="Deskripsi singkat...">{{ trim($setpage->tentang) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-mail"></i></span></div>
                                            <input type="email" name="email" class="form-control" value="{{ $setpage->email }}" placeholder="hello@laundry.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. Telp</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-phone"></i></span></div>
                                            <input type="number" name="no_telp" class="form-control" value="{{ $setpage->no_telp }}" placeholder="081...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>WhatsApp</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-message-circle"></i></span></div>
                                            <input type="text" name="whatsapp" class="form-control" value="{{ $setpage->whatsapp }}" placeholder="62812...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-instagram"></i></span></div>
                                            <input type="text" name="instagram" class="form-control" value="{{ $setpage->instagram }}" placeholder="@username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-facebook"></i></span></div>
                                            <input type="text" name="facebook" class="form-control" value="{{ $setpage->facebook }}" placeholder="username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-twitter"></i></span></div>
                                            <input type="text" name="twitter" class="form-control" value="{{ $setpage->twitter }}" placeholder="@username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Image Hero (Landing Page)</label>
                                        <input type="file" name="img_hero" class="form-control-file">
                                        <small class="text-muted">Rekomendasi ukuran: 1200 × 400 px</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top pt-1">
                            <button type="submit" class="btn btn-primary mr-50">
                                <i class="feather icon-save mr-25"></i> Simpan Perubahan
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== TARGET LAUNDRY ===== --}}
            <div class="tab-pane fade" id="vertical-target" role="tabpanel">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div>
                            <h4 class="card-title mb-25">
                                <i class="feather icon-target mr-50 text-info"></i> Target Laundry
                            </h4>
                            <small class="text-muted">Target volume laundry (kg) yang dipakai sebagai KPI di Finance.</small>
                        </div>
                    </div>
                    <form action="{{ route('set-target.update', Auth::user()->id) }}" method="post">
                        @csrf @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Target per Hari <small class="text-muted">(kg)</small></label>
                                        <input type="number" class="form-control" name="target_day" value="{{ $settarget->target_day }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Target per Bulan <small class="text-muted">(kg)</small></label>
                                        <input type="number" class="form-control" name="target_month" value="{{ $settarget->target_month }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Target per Tahun <small class="text-muted">(kg)</small></label>
                                        <input type="number" class="form-control" name="target_year" value="{{ $settarget->target_year }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top pt-1">
                            <button type="submit" class="btn btn-primary mr-50">
                                <i class="feather icon-save mr-25"></i> Simpan Target
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== TEMA ===== --}}
            <div class="tab-pane fade" id="vertical-theme" role="tabpanel">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div>
                            <h4 class="card-title mb-25">
                                <i class="feather icon-moon mr-50 text-warning"></i> Tema Tampilan
                            </h4>
                            <small class="text-muted">Pilih mode terang atau gelap untuk dashboard kamu.</small>
                        </div>
                    </div>
                    <form action="{{ route('setting-theme.update', Auth::id()) }}" method="post" id="theme-form">
                        @csrf @method('PUT')
                        <div class="card-body">
                            @php $currentTheme = Auth::user()->theme ?? 1; @endphp
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="d-block mb-0" style="cursor:pointer;">
                                        <input type="radio" name="theme" value="0" class="d-none theme-radio" {{ $currentTheme == 0 ? 'checked' : '' }}>
                                        <div class="theme-card p-2 text-center {{ $currentTheme == 0 ? 'is-active' : '' }}"
                                             style="border:2px solid {{ $currentTheme == 0 ? '#7367f0' : '#e5e7eb' }}; border-radius:10px; transition:all .2s;">
                                            <div class="mx-auto mb-1" style="width:100%; height:100px; border-radius:6px; background:linear-gradient(135deg,#f8f9fa 50%,#e9ecef 50%); border:1px solid #dee2e6;"></div>
                                            <h5 class="mb-25"><i class="feather icon-sun text-warning mr-25"></i> Light Mode</h5>
                                            <small class="text-muted">Tampilan terang, ideal untuk siang hari.</small>
                                            @if ($currentTheme == 0)
                                                <div class="mt-1"><span class="badge badge-primary"><i class="feather icon-check"></i> Aktif</span></div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="d-block mb-0" style="cursor:pointer;">
                                        <input type="radio" name="theme" value="1" class="d-none theme-radio" {{ $currentTheme == 1 ? 'checked' : '' }}>
                                        <div class="theme-card p-2 text-center {{ $currentTheme == 1 ? 'is-active' : '' }}"
                                             style="border:2px solid {{ $currentTheme == 1 ? '#7367f0' : '#e5e7eb' }}; border-radius:10px; transition:all .2s;">
                                            <div class="mx-auto mb-1" style="width:100%; height:100px; border-radius:6px; background:linear-gradient(135deg,#283046 50%,#161d31 50%); border:1px solid #3b4253;"></div>
                                            <h5 class="mb-25"><i class="feather icon-moon text-info mr-25"></i> Dark Mode</h5>
                                            <small class="text-muted">Tampilan gelap, ramah mata di malam hari.</small>
                                            @if ($currentTheme == 1)
                                                <div class="mt-1"><span class="badge badge-primary"><i class="feather icon-check"></i> Aktif</span></div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top pt-1">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather icon-save mr-25"></i> Simpan Tema
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== BANK ===== --}}
            <div class="tab-pane fade" id="vertical-bank" role="tabpanel">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-25">
                                <i class="feather icon-credit-card mr-50 text-success"></i> Data Rekening Bank
                            </h4>
                            <small class="text-muted">Akun bank/e-wallet yang ditampilkan di invoice untuk transfer.</small>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addpayment">
                            <i class="feather icon-plus mr-25"></i> Tambah Rekening
                        </button>
                    </div>
                    <div class="card-body">
                        @if (isset($databank) && count($databank) > 0)
                            <div class="row">
                                @foreach ($databank as $bank)
                                    <div class="col-md-4 col-12 mb-1">
                                        <div class="card mb-0" style="background:linear-gradient(135deg,#7367f0,#9e95f5); color:#fff;">
                                            <div class="card-body p-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="text-white mb-0">{{ $bank->nama_bank }}</h6>
                                                    <i class="feather icon-credit-card text-white" style="opacity:.6;"></i>
                                                </div>
                                                <h4 class="text-white text-bold-700 my-1" style="letter-spacing:1px;">{{ $bank->no_rekening }}</h4>
                                                <small class="text-white" style="opacity:.85;">a/n {{ $bank->nama_pemilik }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-3 text-muted">
                                <i class="feather icon-credit-card font-medium-5 d-block mb-1"></i>
                                Belum ada rekening. Klik <strong>Tambah Rekening</strong> di atas.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ===== NOTIFIKASI ===== --}}
            <div class="tab-pane fade" id="vertical-notif" role="tabpanel">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div>
                            <h4 class="card-title mb-25">
                                <i class="feather icon-bell mr-50 text-danger"></i> Notifikasi
                            </h4>
                            <small class="text-muted">Atur email, Telegram & WhatsApp untuk update order.</small>
                        </div>
                    </div>
                    @php
                        $issues = [];
                        if ($setnotif->email && empty($setnotif->mail_host)) {
                            $issues[] = 'Email aktif tapi SMTP Host belum diisi.';
                        }
                        if ($setnotif->email && empty($setnotif->mail_from_address)) {
                            $issues[] = 'Email aktif tapi alamat pengirim (From) belum diisi.';
                        }
                        if (($setnotif->telegram_order_masuk || $setnotif->telegram_order_selesai) && empty($setnotif->telegram_channel_masuk)) {
                            $issues[] = 'Telegram aktif tapi Chat ID / Channel belum diisi.';
                        }
                        if (($setnotif->telegram_order_masuk || $setnotif->telegram_order_selesai) && empty($setnotif->telegram_bot_token)) {
                            $issues[] = 'Telegram aktif tapi Bot Token belum diisi.';
                        }
                        if ($setnotif->wa_order_selesai && empty($setnotif->wa_token)) {
                            $issues[] = 'WhatsApp aktif tapi Token gateway belum diisi.';
                        }
                    @endphp

                    <form action="{{ route('set-notif.update', Auth::id()) }}" method="post">
                        @csrf @method('PUT')
                        <div class="card-body">
                            @if (!empty($issues))
                                <div class="alert alert-warning mb-2">
                                    <h6 class="alert-heading">
                                        <i class="feather icon-alert-triangle mr-25"></i>
                                        Konfigurasi belum lengkap — notifikasi tidak akan terkirim:
                                    </h6>
                                    <ul class="mb-0 mt-50">
                                        @foreach ($issues as $iss)<li>{{ $iss }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="alert alert-info mb-2">
                                <i class="feather icon-info mr-25"></i>
                                Semua kredensial disimpan di database & otomatis dipakai aplikasi.
                                Baca <a href="{{ url('dokumentasi') }}"><b>Dokumentasi</b></a> untuk panduan setup Telegram bot & WhatsApp gateway.
                            </div>

                            {{-- ===== SUB-TAB NAV ===== --}}
                            <ul class="nav nav-pills mb-2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="ntf-pill-email" data-toggle="pill" href="#ntf-pane-email" role="tab">
                                        <i class="feather icon-mail mr-25"></i> Email
                                        @if ($setnotif->email && (empty($setnotif->mail_host) || empty($setnotif->mail_from_address)))
                                            <span class="badge badge-danger ml-25">!</span>
                                        @elseif ($setnotif->email)
                                            <span class="badge badge-success ml-25"><i class="feather icon-check"></i></span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ntf-pill-telegram" data-toggle="pill" href="#ntf-pane-telegram" role="tab">
                                        <i class="feather icon-send mr-25"></i> Telegram
                                        @if (($setnotif->telegram_order_masuk || $setnotif->telegram_order_selesai) && (empty($setnotif->telegram_channel_masuk) || empty($setnotif->telegram_bot_token)))
                                            <span class="badge badge-danger ml-25">!</span>
                                        @elseif ($setnotif->telegram_order_masuk || $setnotif->telegram_order_selesai)
                                            <span class="badge badge-success ml-25"><i class="feather icon-check"></i></span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ntf-pill-wa" data-toggle="pill" href="#ntf-pane-wa" role="tab">
                                        <i class="feather icon-smartphone mr-25"></i> WhatsApp
                                        @if ($setnotif->wa_order_selesai && empty($setnotif->wa_token))
                                            <span class="badge badge-danger ml-25">!</span>
                                        @elseif ($setnotif->wa_order_selesai)
                                            <span class="badge badge-success ml-25"><i class="feather icon-check"></i></span>
                                        @endif
                                    </a>
                                </li>
                            </ul>

                            {{-- ===== SUB-TAB PANELS ===== --}}
                            <div class="tab-content">

                            {{-- ===== EMAIL PANEL ===== --}}
                            <div class="tab-pane fade show active" id="ntf-pane-email" role="tabpanel">
                            <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">
                                <i class="feather icon-mail mr-25 text-primary"></i> Email (SMTP)
                            </h6>
                            <div class="p-1 mb-1" style="background:rgba(115,103,240,.04); border-radius:6px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Email Notification</h6>
                                        <small class="text-muted">Kirim email ke customer saat order dibuat & selesai.</small>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="email" value="0">
                                        <input type="checkbox" class="custom-control-input ntf-mail-toggle" name="email" {{ $setnotif->email == 1 ? 'checked' : '' }} value="1" id="ntf-email">
                                        <label class="custom-control-label" for="ntf-email"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="mail-config-section">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-bold-600">SMTP Host</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-server"></i></span></div>
                                            <input type="text" name="mail_host" class="form-control @error('mail_host') is-invalid @enderror"
                                                   placeholder="smtp.gmail.com" value="{{ old('mail_host', $setnotif->mail_host) }}">
                                        </div>
                                        @error('mail_host')<small class="text-danger d-block"><i class="feather icon-alert-circle"></i> {{ $message }}</small>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-bold-600">Port</label>
                                        <input type="number" name="mail_port" class="form-control" placeholder="587"
                                               value="{{ old('mail_port', $setnotif->mail_port) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-bold-600">Username</label>
                                        <input type="text" name="mail_username" class="form-control" autocomplete="off"
                                               placeholder="email@domain.com" value="{{ old('mail_username', $setnotif->mail_username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-bold-600">Password / App Password</label>
                                        <input type="password" name="mail_password" class="form-control" autocomplete="new-password"
                                               placeholder="{{ $setnotif->mail_password ? '••••••••' : 'masukkan password' }}">
                                        <small class="text-muted">Kosongkan kalau tidak ingin diubah.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-bold-600">Encryption</label>
                                        <select name="mail_encryption" class="form-control">
                                            <option value="">— None —</option>
                                            <option value="tls" {{ ($setnotif->mail_encryption ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ ($setnotif->mail_encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-bold-600">From Address</label>
                                        <input type="email" name="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror"
                                               placeholder="no-reply@laundry.com"
                                               value="{{ old('mail_from_address', $setnotif->mail_from_address) }}">
                                        @error('mail_from_address')<small class="text-danger d-block">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-bold-600">From Name</label>
                                        <input type="text" name="mail_from_name" class="form-control"
                                               placeholder="E-Laundry"
                                               value="{{ old('mail_from_name', $setnotif->mail_from_name) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block mb-2">
                                        <i class="feather icon-info mr-25"></i>
                                        Untuk Gmail, aktifkan 2FA lalu generate <b>App Password</b>.
                                        Port umum: <code>587</code> (TLS) atau <code>465</code> (SSL).
                                    </small>
                                </div>
                            </div>

                            </div> {{-- /ntf-pane-email --}}

                            {{-- ===== TELEGRAM PANEL ===== --}}
                            <div class="tab-pane fade" id="ntf-pane-telegram" role="tabpanel">
                            <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">
                                <i class="feather icon-send mr-25 text-info"></i> Telegram
                            </h6>
                            <div class="p-1 mb-1" style="background:rgba(0,207,232,.04); border-radius:6px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Telegram: Order Masuk</h6>
                                        <small class="text-muted">Notif Telegram setiap ada order baru.</small>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="telegram_order_masuk" value="0">
                                        <input type="checkbox" class="custom-control-input ntf-tg-toggle" name="telegram_order_masuk" {{ $setnotif->telegram_order_masuk == 1 ? 'checked' : '' }} value="1" id="ntf-tg-in">
                                        <label class="custom-control-label" for="ntf-tg-in"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="p-1 mb-1" style="background:rgba(0,207,232,.04); border-radius:6px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Telegram: Order Selesai</h6>
                                        <small class="text-muted">Notif Telegram setiap order selesai diproses.</small>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="telegram_order_selesai" value="0">
                                        <input type="checkbox" class="custom-control-input ntf-tg-toggle" name="telegram_order_selesai" {{ $setnotif->telegram_order_selesai == 1 ? 'checked' : '' }} value="1" id="ntf-tg-done">
                                        <label class="custom-control-label" for="ntf-tg-done"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="text-bold-600">Chat ID / Channel Telegram (Order Masuk)</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-hash"></i></span></div>
                                    <input type="text" name="telegram_channel_masuk"
                                           class="form-control @error('telegram_channel_masuk') is-invalid @enderror"
                                           placeholder="-100xxxxxxxxxx atau @channel"
                                           value="{{ old('telegram_channel_masuk', $setnotif->telegram_channel_masuk) }}">
                                </div>
                                @error('telegram_channel_masuk')
                                    <small class="text-danger d-block"><i class="feather icon-alert-circle"></i> {{ $message }}</small>
                                @enderror
                                <small class="text-muted">Tip: untuk dapat Chat ID, kirim pesan ke bot lalu cek <code>getUpdates</code>.</small>
                            </div>

                            <div class="form-group">
                                <label class="text-bold-600">Chat ID / Channel Telegram (Order Selesai)</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-hash"></i></span></div>
                                    <input type="text" name="telegram_channel_selesai"
                                           class="form-control"
                                           placeholder="Kosongkan kalau sama dengan channel Order Masuk"
                                           value="{{ old('telegram_channel_selesai', $setnotif->telegram_channel_selesai) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="text-bold-600">Telegram Bot Token</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-key"></i></span></div>
                                    <input type="text" name="telegram_bot_token"
                                           class="form-control @error('telegram_bot_token') is-invalid @enderror"
                                           placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11"
                                           value="{{ old('telegram_bot_token', $setnotif->telegram_bot_token) }}">
                                </div>
                                @error('telegram_bot_token')<small class="text-danger d-block"><i class="feather icon-alert-circle"></i> {{ $message }}</small>@enderror
                                <small class="text-muted">
                                    Buat bot lewat <a href="https://t.me/BotFather" target="_blank">@BotFather</a>, lalu salin token-nya.
                                </small>
                            </div>

                            </div> {{-- /ntf-pane-telegram --}}

                            {{-- ===== WHATSAPP PANEL ===== --}}
                            <div class="tab-pane fade" id="ntf-pane-wa" role="tabpanel">
                            <h6 class="text-bold-600 text-uppercase mb-1" style="font-size:.75rem; letter-spacing:1px;">
                                <i class="feather icon-smartphone mr-25 text-success"></i> WhatsApp
                            </h6>
                            <div class="p-1 mb-1" style="background:rgba(40,199,111,.04); border-radius:6px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">WhatsApp: Order Selesai</h6>
                                        <small class="text-muted">Kirim WA ke customer saat laundry siap diambil.</small>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="wa_order_selesai" value="0">
                                        <input type="checkbox" class="custom-control-input ntf-wa-toggle" name="wa_order_selesai" {{ $setnotif->wa_order_selesai == 1 ? 'checked' : '' }} value="1" id="ntf-wa">
                                        <label class="custom-control-label" for="ntf-wa"></label>
                                    </div>
                                </div>
                            </div>

                            @php
                                $currentProvider = old('wa_provider', $setnotif->wa_provider ?? 'kirimwa');
                            @endphp
                            <div class="form-group">
                                <label class="text-bold-600">Pilih Gateway WhatsApp <span class="text-danger">*</span></label>
                                <select name="wa_provider" id="wa-provider" class="form-control">
                                    <option value="kirimwa"  {{ $currentProvider === 'kirimwa'  ? 'selected' : '' }}>Kirimwa.id</option>
                                    <option value="fonnte"   {{ $currentProvider === 'fonnte'   ? 'selected' : '' }}>Fonnte</option>
                                    <option value="wablas"   {{ $currentProvider === 'wablas'   ? 'selected' : '' }}>Wablas</option>
                                    <option value="wa_cloud" {{ $currentProvider === 'wa_cloud' ? 'selected' : '' }}>WA Cloud API (Meta resmi)</option>
                                </select>
                            </div>

                            {{-- Hint per provider --}}
                            <div class="alert alert-info py-1 mb-2" id="wa-hint-kirimwa" style="display:none;">
                                <small>
                                    <b>Kirimwa.id</b> — Format nomor: <code>628xxx</code>. Auth: <code>Bearer {token}</code>.
                                    Body JSON dengan field <code>phone_number</code>, <code>message</code>, <code>device_id</code>.
                                    URL default: <code>https://api.kirimwa.id/v1/messages</code>.
                                </small>
                            </div>
                            <div class="alert alert-info py-1 mb-2" id="wa-hint-fonnte" style="display:none;">
                                <small>
                                    <b>Fonnte</b> — Format nomor: <code>628xxx</code>. Auth: header <code>Authorization: {token}</code> (tanpa Bearer).
                                    Body form-urlencoded dengan <code>target</code> + <code>message</code>.
                                    URL default: <code>https://api.fonnte.com/send</code>. Device ID tidak dipakai.
                                </small>
                            </div>
                            <div class="alert alert-info py-1 mb-2" id="wa-hint-wablas" style="display:none;">
                                <small>
                                    <b>Wablas</b> — Format nomor: <code>628xxx</code>. Auth: header <code>Authorization: {token}</code> (tanpa Bearer).
                                    Body form-urlencoded dengan <code>phone</code> + <code>message</code>.
                                    URL <b>wajib disesuaikan dengan region kamu</b>, mis. <code>https://jkt.wablas.com/api/send-message</code>.
                                </small>
                            </div>
                            <div class="alert alert-info py-1 mb-2" id="wa-hint-wa_cloud" style="display:none;">
                                <small>
                                    <b>WA Cloud API (Meta)</b> — Format nomor: <code>628xxx</code> (tanpa <code>+</code>).
                                    Token = <b>Permanent System Access Token</b> dari Meta Developer.
                                    Isi field <b>Device ID / Phone Number ID</b> dengan Phone Number ID dari WhatsApp Business Account.
                                    URL otomatis ke <code>graph.facebook.com</code> kalau dikosongkan.
                                </small>
                            </div>

                            <div class="form-group">
                                <label class="text-bold-600">Token / API Key <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-key"></i></span></div>
                                    <input type="text" name="wa_token"
                                           class="form-control @error('wa_token') is-invalid @enderror"
                                           placeholder="Masukkan token dari penyedia gateway"
                                           value="{{ old('wa_token', $setnotif->wa_token) }}">
                                </div>
                                @error('wa_token')<small class="text-danger d-block"><i class="feather icon-alert-circle"></i> {{ $message }}</small>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-bold-600">URL Gateway</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather icon-link"></i></span></div>
                                            <input type="text" name="wa_gateway_url" class="form-control"
                                                   placeholder="https://api.kirimwa.id/v1/messages"
                                                   value="{{ old('wa_gateway_url', $setnotif->wa_gateway_url) }}">
                                        </div>
                                        <small class="text-muted">Kosongkan kalau pakai default (kirimwa.id).</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="text-bold-600" id="wa-device-label">Device ID</label>
                                        <input type="text" name="wa_device_id" id="wa-device-id"
                                               class="form-control @error('wa_device_id') is-invalid @enderror"
                                               placeholder="iphone" value="{{ old('wa_device_id', $setnotif->wa_device_id) }}">
                                        <small class="text-muted" id="wa-device-hint">Identifier perangkat (provider-specific).</small>
                                        @error('wa_device_id')<small class="text-danger d-block">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                            </div>
                            </div> {{-- /ntf-pane-wa --}}

                            </div> {{-- /tab-content --}}
                        </div>
                        <div class="card-body border-top pt-1">
                            <button type="submit" class="btn btn-primary mr-50">
                                <i class="feather icon-save mr-25"></i> Simpan Notifikasi
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@include('modul_admin.setting.modal')
@endsection

@section('scripts')
<script>
@if (count($errors) > 0)
    $(function() { $('#addpayment').modal('show'); });
@endif

// Visual highlight saat radio tema diklik
$(document).on('change', '.theme-radio', function () {
    $('.theme-card').css('border-color', '#e5e7eb').removeClass('is-active');
    $(this).siblings('.theme-card').css('border-color', '#7367f0').addClass('is-active');
});

// Buka tab notifikasi otomatis kalau ada error validasi terkait notif
@if ($errors->hasAny(['telegram_channel_masuk', 'telegram_bot_token', 'wa_token', 'wa_device_id', 'mail_host', 'mail_from_address']))
    $(function () {
        $('#pill-notif').tab('show');
        // Buka sub-tab yang punya error
        @if ($errors->hasAny(['mail_host', 'mail_from_address']))
            $('#ntf-pill-email').tab('show');
        @elseif ($errors->hasAny(['telegram_channel_masuk', 'telegram_bot_token']))
            $('#ntf-pill-telegram').tab('show');
        @elseif ($errors->hasAny(['wa_token', 'wa_device_id']))
            $('#ntf-pill-wa').tab('show');
        @endif
    });
@endif

// ===== Live warning: toggle ON tapi field wajib kosong =====
(function () {
    function showFieldWarning($field, msg) {
        $field.addClass('is-invalid');
        var $next = $field.closest('.form-group').find('.live-warn');
        if (!$next.length) {
            $next = $('<small class="text-warning d-block mt-25 live-warn"><i class="feather icon-alert-circle"></i> </small>')
                .appendTo($field.closest('.form-group'));
        }
        $next.html('<i class="feather icon-alert-circle"></i> ' + msg);
    }
    function clearFieldWarning($field) {
        $field.removeClass('is-invalid');
        $field.closest('.form-group').find('.live-warn').remove();
    }

    function checkMail() {
        var on = $('#ntf-email').is(':checked');
        var $host = $('input[name=mail_host]');
        var $from = $('input[name=mail_from_address]');
        if (on && !$host.val()) showFieldWarning($host, 'Wajib diisi kalau Email aktif.');
        else clearFieldWarning($host);
        if (on && !$from.val()) showFieldWarning($from, 'Wajib diisi kalau Email aktif.');
        else clearFieldWarning($from);
    }
    function checkTelegram() {
        var on = $('#ntf-tg-in').is(':checked') || $('#ntf-tg-done').is(':checked');
        var $ch = $('input[name=telegram_channel_masuk]');
        var $tok = $('input[name=telegram_bot_token]');
        if (on && !$ch.val()) showFieldWarning($ch, 'Wajib diisi kalau Telegram aktif.');
        else clearFieldWarning($ch);
        if (on && !$tok.val()) showFieldWarning($tok, 'Wajib diisi kalau Telegram aktif.');
        else clearFieldWarning($tok);
    }
    function checkWA() {
        var on = $('#ntf-wa').is(':checked');
        var $tok = $('input[name=wa_token]');
        if (on && !$tok.val()) showFieldWarning($tok, 'Wajib diisi kalau WhatsApp aktif.');
        else clearFieldWarning($tok);
    }
    function checkAll() { checkMail(); checkTelegram(); checkWA(); }

    $(document).on('change', '#ntf-email, #ntf-tg-in, #ntf-tg-done, #ntf-wa', checkAll);
    $(document).on('input',
        'input[name=mail_host], input[name=mail_from_address], ' +
        'input[name=telegram_channel_masuk], input[name=telegram_bot_token], input[name=wa_token]',
        checkAll
    );

    // Jalankan saat halaman load (kalau user buka tab notif)
    $(document).on('shown.bs.tab', 'a[href="#vertical-notif"]', checkAll);
    $(function () {
        if ($('#vertical-notif').hasClass('active')) checkAll();
    });
})();

// ===== WA Provider selector — swap hint & relabel device field =====
(function () {
    function applyProvider() {
        var p = $('#wa-provider').val() || 'kirimwa';
        $('[id^=wa-hint-]').hide();
        $('#wa-hint-' + p).show();

        // WA Cloud: device_id sebenarnya Phone Number ID
        if (p === 'wa_cloud') {
            $('#wa-device-label').html('Phone Number ID <span class="text-danger">*</span>');
            $('#wa-device-id').attr('placeholder', '1234567890123');
            $('#wa-device-hint').text('Phone Number ID dari WhatsApp Business Account Meta.');
        } else if (p === 'fonnte' || p === 'wablas') {
            $('#wa-device-label').text('Device ID (opsional)');
            $('#wa-device-id').attr('placeholder', 'tidak dipakai');
            $('#wa-device-hint').text('Tidak diperlukan untuk provider ini.');
        } else {
            $('#wa-device-label').text('Device ID');
            $('#wa-device-id').attr('placeholder', 'iphone');
            $('#wa-device-hint').text('Identifier perangkat di akun Kirimwa.');
        }
    }
    $(document).on('change', '#wa-provider', applyProvider);
    $(function () { applyProvider(); });
})();
</script>
@endsection
