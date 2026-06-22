@extends('layouts.backend')
@section('title','Karyawan - Data Customer')
@section('header','Data Customer')
@section('content')

@php
    $total = $customer->count();
    $bulan = $customer->filter(fn($c) => \Carbon\Carbon::parse($c->created_at)->isCurrentMonth())->count();
    $hari  = $customer->filter(fn($c) => \Carbon\Carbon::parse($c->created_at)->isToday())->count();
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">Customer Saya</h2>
        <p class="text-muted mb-0">
            Daftar customer yang kamu tambahkan. Klik <em>Detail</em> untuk lihat histori transaksi mereka.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ url('customers-create') }}" class="btn btn-primary">
            <i class="feather icon-user-plus mr-25"></i> Tambah Customer
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

{{-- ============ NEW CUSTOMER CREDENTIALS (one-time view) ============ --}}
@php $newCust = Session::get('new_customer'); @endphp
@if ($newCust)
    <div class="card border-warning mb-2" style="border-left: 4px solid var(--warning, #ff9f43); background: rgba(255,159,67,.04);">
        <div class="card-header pb-50">
            <h4 class="card-title mb-0 d-flex align-items-center">
                <i class="feather icon-lock mr-50 text-warning"></i>
                Detail Login Customer Baru
                <span class="badge badge-light-warning ml-1" style="font-size:.7rem">SEKALI TAMPIL</span>
            </h4>
        </div>
        <div class="card-body pt-1">
            {{-- Email status notice --}}
            @if ($newCust['email_status'] === 'sent')
                <div class="alert alert-info py-50 mb-1">
                    <i class="feather icon-mail mr-25"></i>
                    Email berisi info login sudah dikirim ke <strong>{{ $newCust['email'] }}</strong>.
                </div>
            @elseif ($newCust['email_status'] === 'failed')
                <div class="alert alert-danger py-50 mb-1">
                    <i class="feather icon-alert-triangle mr-25"></i>
                    <strong>Email gagal terkirim.</strong> Mungkin SMTP belum dikonfigurasi (cek <code>.env</code> file: <code>MAIL_HOST</code>, <code>MAIL_USERNAME</code>, <code>MAIL_PASSWORD</code>).
                    Silakan kirim manual ke customer via WhatsApp.
                    @if(!empty($newCust['email_error']))
                        <details class="mt-50"><summary><small class="text-muted">Detail error</small></summary>
                            <pre class="mb-0 mt-25" style="font-size:.75rem; color:var(--text-muted);">{{ $newCust['email_error'] }}</pre>
                        </details>
                    @endif
                </div>
            @else
                <div class="alert alert-warning py-50 mb-1">
                    <i class="feather icon-info mr-25"></i>
                    <strong>Notifikasi email tidak aktif.</strong>
                    Aktifkan di <a href="{{ url('karyawan-setting') }}">Pengaturan</a> jika ingin email otomatis terkirim.
                </div>
            @endif

            <div class="row">
                <div class="col-md-4 col-12 mb-1">
                    <small class="text-muted d-block">Nama</small>
                    <strong>{{ $newCust['name'] }}</strong>
                </div>
                <div class="col-md-4 col-12 mb-1">
                    <small class="text-muted d-block">Email</small>
                    <strong>{{ $newCust['email'] }}</strong>
                </div>
                <div class="col-md-4 col-12 mb-1">
                    <small class="text-muted d-block">Password (sementara)</small>
                    <div class="input-group input-group-merge">
                        <input type="text" id="newCustPass" class="form-control text-bold-700" value="{{ $newCust['password'] }}" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-flat-primary" onclick="copyPass()" title="Salin password">
                                <i class="feather icon-copy" id="copyIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap" style="gap:.5rem;">
                @if(!empty($newCust['no_telp']))
                    @php
                        $waMsg = "Halo {$newCust['name']}, akun laundry Anda sudah dibuat.\n\n"
                               . "Login di: ".url('/login')."\n"
                               . "Email: {$newCust['email']}\n"
                               . "Password: {$newCust['password']}\n\n"
                               . "Mohon ganti password setelah login pertama. Terima kasih!";
                    @endphp
                    <a href="https://wa.me/{{ $newCust['no_telp'] }}?text={{ urlencode($waMsg) }}"
                       target="_blank" class="btn btn-success">
                        <i class="feather icon-message-circle mr-25"></i> Kirim via WhatsApp
                    </a>
                @endif
                <button type="button" class="btn btn-outline-secondary" onclick="this.closest('.card').remove()">
                    <i class="feather icon-x mr-25"></i> Tutup
                </button>
            </div>
        </div>
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
                    <h2 class="text-bold-700 mb-0">{{ $bulan }}</h2>
                    <p class="mb-0 text-muted">Baru Bulan Ini</p>
                </div>
                <div class="avatar bg-rgba-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-user-plus text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $hari }}</h2>
                    <p class="mb-0 text-muted">Baru Hari Ini</p>
                </div>
                <div class="avatar bg-rgba-info p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-sun text-info font-medium-5"></i>
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
                        Total {{ $total }} customer yang kamu tambahkan
                    </p>
                </div>
                <div class="mt-1 mt-md-0">
                    <div class="input-group input-group-merge" style="min-width: 240px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                        </div>
                        <input type="text" id="cust-search" class="form-control" placeholder="Cari nama, email, telp...">
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
                            <th>Terdaftar</th>
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
                                    @if($item->no_telp)
                                        <a href="https://wa.me/{{ $item->no_telp }}" target="_blank" class="text-success" title="Chat WhatsApp">
                                            <i class="feather icon-message-circle mr-25"></i> {{ $item->no_telp }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                </td>
                                <td class="text-right">
                                    <a href="{{ url('customers', $item->id) }}"
                                       class="btn btn-sm btn-flat-primary" title="Lihat detail">
                                        <i class="feather icon-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="feather icon-user-plus font-medium-5 d-block mb-1"></i>
                                    Belum ada customer. Klik <strong>Tambah Customer</strong> di atas.
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
<script>
function copyPass() {
    var inp = document.getElementById('newCustPass');
    inp.select(); inp.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(inp.value).then(function() {
        var icon = document.getElementById('copyIcon');
        icon.classList.remove('icon-copy');
        icon.classList.add('icon-check');
        setTimeout(function() {
            icon.classList.remove('icon-check');
            icon.classList.add('icon-copy');
        }, 1500);
    });
}

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
