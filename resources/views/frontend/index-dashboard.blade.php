@extends('layouts.frontend-dashboard')
@section('title', 'Selamat Datang')

@section('content')

{{-- ====================== NAVBAR ====================== --}}
<div class="nav-wrap">
    <div class="container-x nav-inner">
        <a href="{{ url('/') }}" class="nav-brand">
            <span class="dot"></span>
            {{ $setpage->judul ?? 'E-Laundry' }}
        </a>
        <nav class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#cara-kerja">Cara Kerja</a>
            <a href="#harga">Harga</a>
            <a href="#testimoni">Testimoni</a>
            <a href="#faq">FAQ</a>
        </nav>
        <div class="nav-cta">
            <button class="theme-toggle" onclick="toggleTheme()" title="Ganti theme">
                <i data-feather="sun" class="theme-toggle-icon" width="18" height="18"></i>
            </button>
            @auth
                <a href="{{ url('/home') }}" class="btn-x btn-primary-x">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-x btn-ghost-x d-none d-sm-inline-flex">Masuk</a>
                <a href="#tracking" class="btn-x btn-primary-x">Lacak Order</a>
            @endauth
        </div>
    </div>
</div>

{{-- ====================== HERO + TRACKING ====================== --}}
<section class="hero">
    <div class="container-x hero-grid">
        <div class="reveal">
            <div class="hero-pill">
                <span class="badge-new">BARU</span>
                Notifikasi WhatsApp otomatis untuk customer
            </div>
            <h1>
                Kelola Laundry-mu <br>
                Lebih <span class="grad">Cerdas &amp; Cepat</span>
            </h1>
            <p class="lead-x">
                {{ $setpage->deskripsi ?? 'E-Laundry membantu kamu mengelola order, pembayaran, dan laporan keuangan laundry dalam satu dashboard. Real-time, mobile-friendly, dan mudah dipakai karyawan.' }}
            </p>
            <div class="d-flex flex-wrap" style="gap:.75rem;">
                <a href="#tracking" class="btn-x btn-primary-x">
                    <i data-feather="search" width="18" height="18"></i> Lacak Order Sekarang
                </a>
                <a href="#fitur" class="btn-x btn-ghost-x">
                    Pelajari Fitur <i data-feather="arrow-right" width="18" height="18"></i>
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat"><strong>500+</strong><span>Order/hari</span></div>
                <div class="stat"><strong>98%</strong><span>Kepuasan</span></div>
                <div class="stat"><strong>24/7</strong><span>Tracking</span></div>
            </div>
        </div>

        <div class="track-card reveal" id="tracking">
            <h3><i data-feather="search" width="18" height="18"></i> Lacak Status Laundry</h3>
            <p class="small-muted">Masukkan nomor invoice yang kamu terima saat order.</p>
            <div class="track-input">
                <input type="text" id="search_status" placeholder="Contoh: TR0392928" autocomplete="off">
                <button class="btn-x btn-primary-x" id="search-btn">
                    Cek <i data-feather="arrow-right" width="16" height="16"></i>
                </button>
            </div>
            <div class="track-result" id="track-result">
                <div class="row-info"><span>Customer</span><strong id="r-customer">-</strong></div>
                <div class="row-info"><span>Tanggal Order</span><strong id="r-tgl">-</strong></div>
                <div class="row-info"><span>Status</span><span class="status-pill" id="r-status">-</span></div>
            </div>
            <p class="small-muted mt-3 mb-0" style="font-size:.8rem">
                Tip: Cek email/SMS untuk nomor invoice kamu.
            </p>
        </div>
    </div>
</section>

{{-- ====================== FITUR ====================== --}}
<section class="section" id="fitur">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="section-tag">Fitur Unggulan</span>
            <h2>Semua yang Kamu Butuh, Dalam Satu Aplikasi</h2>
            <p>Dirancang khusus untuk pelaku usaha laundry kecil hingga menengah. Tidak ribet, langsung pakai.</p>
        </div>
        <div class="text-center"><span class="swipe-hint">← Geser untuk lihat semua →</span></div>
        <div class="features-grid">
            <div class="feature reveal">
                <div class="feature-icon ic-primary"><i data-feather="package" width="22" height="22"></i></div>
                <h4>Manajemen Order</h4>
                <p>Catat order masuk, status proses, hingga pengambilan dalam beberapa klik. Karyawan tinggal update.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-success"><i data-feather="message-circle" width="22" height="22"></i></div>
                <h4>Notifikasi WhatsApp</h4>
                <p>Customer otomatis dapat pesan saat laundry mereka selesai. Mengurangi telpon-telpon yang mengganggu.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-info"><i data-feather="bar-chart-2" width="22" height="22"></i></div>
                <h4>Laporan Keuangan</h4>
                <p>Pendapatan harian, bulanan, tahunan otomatis ter-rekap. Ekspor ke Excel kapan saja.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-warning"><i data-feather="users" width="22" height="22"></i></div>
                <h4>Multi-Karyawan</h4>
                <p>Setiap karyawan punya akun sendiri dengan akses terbatas. Lihat performa per karyawan.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-danger"><i data-feather="credit-card" width="22" height="22"></i></div>
                <h4>Pembayaran Fleksibel</h4>
                <p>Cash, transfer bank, atau bayar nanti. Sistem pencatatan utang piutang yang rapi.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-primary"><i data-feather="printer" width="22" height="22"></i></div>
                <h4>Cetak Invoice</h4>
                <p>Invoice PDF profesional otomatis tergenerate. Tinggal print dan kasih ke customer.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-info"><i data-feather="smartphone" width="22" height="22"></i></div>
                <h4>Mobile-Friendly</h4>
                <p>Akses dari HP, tablet, atau laptop. Karyawan bisa update order dari mana saja.</p>
            </div>
            <div class="feature reveal">
                <div class="feature-icon ic-success"><i data-feather="shield" width="22" height="22"></i></div>
                <h4>Data Aman</h4>
                <p>Backup otomatis dan role-based access. Hanya yang berwenang yang bisa lihat data sensitif.</p>
            </div>
        </div>
    </div>
</section>

{{-- ====================== CARA KERJA ====================== --}}
<section class="section" id="cara-kerja" style="background: var(--bg-elev);">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="section-tag">Cara Kerja</span>
            <h2>Mulai Pakai dalam 3 Langkah</h2>
            <p>Tidak perlu training berhari-hari. Setup, input order, beres.</p>
        </div>
        <div class="text-center"><span class="swipe-hint">← Geser untuk lihat semua →</span></div>
        <div class="steps-grid">
            <div class="step reveal">
                <div class="step-num">1</div>
                <h4>Daftar &amp; Setup</h4>
                <p>Buat akun, masukkan info outlet, tambahkan harga layanan dan karyawan kamu.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">2</div>
                <h4>Input Order Masuk</h4>
                <p>Setiap customer datang, input nama, jenis layanan, dan berat. Invoice otomatis tercetak.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">3</div>
                <h4>Selesai &amp; Pickup</h4>
                <p>Update status jadi "Selesai", customer dapat notif WhatsApp, datang ambil &amp; bayar.</p>
            </div>
        </div>
    </div>
</section>

{{-- ====================== HARGA ====================== --}}
<section class="section" id="harga">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="section-tag">Paket Harga</span>
            <h2>Mulai Gratis, Upgrade Saat Butuh</h2>
            <p>Pilih paket yang sesuai skala usaha laundry-mu. Bisa upgrade/downgrade kapan saja.</p>
        </div>
        <div class="text-center"><span class="swipe-hint">← Geser untuk lihat semua paket →</span></div>
        <div class="pricing-grid">

            <div class="price-card reveal">
                <div class="price-name">Starter</div>
                <div class="price-amount"><strong>Gratis</strong></div>
                <p class="price-desc">Untuk laundry kecil yang baru mulai digitalisasi.</p>
                <ul class="price-list">
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Hingga 50 order/bulan</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 1 karyawan</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Laporan dasar</li>
                    <li class="dim"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Notifikasi WhatsApp</li>
                    <li class="dim"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Multi-outlet</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-x btn-ghost-x" style="width:100%; justify-content:center;">Mulai Gratis</a>
            </div>

            <div class="price-card featured reveal">
                <span class="price-badge">PALING POPULER</span>
                <div class="price-name">Pro</div>
                <div class="price-amount"><strong>Rp 99rb</strong><small>/bulan</small></div>
                <p class="price-desc">Untuk laundry rumahan yang sudah ramai customer.</p>
                <ul class="price-list">
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> <strong>Order unlimited</strong></li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Hingga 5 karyawan</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Laporan lengkap + ekspor</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Notifikasi WhatsApp otomatis</li>
                    <li class="dim"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Multi-outlet</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-x btn-primary-x" style="width:100%; justify-content:center;">Pilih Pro</a>
            </div>

            <div class="price-card reveal">
                <div class="price-name">Business</div>
                <div class="price-amount"><strong>Rp 249rb</strong><small>/bulan</small></div>
                <p class="price-desc">Untuk laundry dengan banyak cabang &amp; karyawan.</p>
                <ul class="price-list">
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Semua fitur <strong>Pro</strong></li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Karyawan unlimited</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Multi-outlet &amp; konsolidasi</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Prioritas support 24/7</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Custom branding invoice</li>
                </ul>
                <a href="https://wa.me/{{ $setpage->whatsapp ?? '' }}" target="_blank" class="btn-x btn-ghost-x" style="width:100%; justify-content:center;">Hubungi Kami</a>
            </div>

        </div>
    </div>
</section>

{{-- ====================== TESTIMONI ====================== --}}
<section class="section" id="testimoni" style="background: var(--bg-elev);">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="section-tag">Testimoni</span>
            <h2>Apa Kata Pengguna Kami</h2>
            <p>Ratusan pelaku usaha laundry sudah merasakan manfaatnya.</p>
        </div>
        <div class="text-center"><span class="swipe-hint">← Geser untuk lihat semua →</span></div>
        <div class="testi-grid">
            <div class="testi reveal">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-quote">"Dulu order suka kelupaan karena masih dicatat manual. Sejak pakai E-Laundry, customer dapat notif sendiri, gak ada lagi yang protes."</p>
                <div class="testi-author">
                    <div class="avatar">SH</div>
                    <div><strong>Sari Handayani</strong><span>Owner · Laundry Bersih Jaya</span></div>
                </div>
            </div>
            <div class="testi reveal">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-quote">"Laporan keuangan jadi rapi banget. Pajak tahunan udah gak pusing lagi tinggal ekspor Excel. Worth it sih."</p>
                <div class="testi-author">
                    <div class="avatar">BW</div>
                    <div><strong>Budi Wijaya</strong><span>Owner · Cuci Kilat Express</span></div>
                </div>
            </div>
            <div class="testi reveal">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-quote">"Karyawan saya yang gaptek pun bisa pakai. Tampilannya simple, gak ribet kayak software laundry lain yang pernah saya coba."</p>
                <div class="testi-author">
                    <div class="avatar">RP</div>
                    <div><strong>Rina Pertiwi</strong><span>Owner · Pelangi Laundry</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====================== FAQ ====================== --}}
<section class="section" id="faq">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="section-tag">FAQ</span>
            <h2>Pertanyaan yang Sering Ditanyakan</h2>
            <p>Belum nemu jawabannya? Hubungi kami via WhatsApp di pojok kanan bawah.</p>
        </div>
        <div class="faq">
            <div class="faq-item reveal">
                <div class="faq-q"><span>Apakah E-Laundry benar-benar gratis?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Ya, paket Starter sepenuhnya gratis dengan batasan 50 order per bulan dan 1 karyawan. Cocok untuk laundry yang baru mulai. Upgrade ke Pro jika order sudah lebih banyak.</div>
            </div>
            <div class="faq-item reveal">
                <div class="faq-q"><span>Apakah data laundry saya aman?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Tentu. Semua data dienkripsi dan disimpan di server yang aman. Kami juga melakukan backup harian otomatis sehingga data tidak akan hilang.</div>
            </div>
            <div class="faq-item reveal">
                <div class="faq-q"><span>Bisa dipakai di HP?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Bisa. E-Laundry sepenuhnya responsive, jadi bisa diakses dari HP, tablet, maupun komputer. Cukup buka browser, login, langsung pakai.</div>
            </div>
            <div class="faq-item reveal">
                <div class="faq-q"><span>Bagaimana cara karyawan saya update order?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Setiap karyawan punya akun login sendiri dengan akses terbatas. Mereka bisa input order baru, update status (process → selesai → diambil), tanpa bisa melihat data keuangan/laporan.</div>
            </div>
            <div class="faq-item reveal">
                <div class="faq-q"><span>Bisa upgrade/downgrade paket kapan saja?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Bisa banget. Tidak ada kontrak. Upgrade saat butuh, downgrade saat sedang sepi. Pembayaran prorata.</div>
            </div>
            <div class="faq-item reveal">
                <div class="faq-q"><span>Apakah ada training?</span>
                    <i data-feather="chevron-down" class="chev" width="20" height="20"></i></div>
                <div class="faq-a">Untuk paket Pro dan Business, kami sediakan video tutorial dan onboarding 1-on-1 via Zoom. Paket Starter tetap bisa pakai dokumentasi tertulis dan tutorial.</div>
            </div>
        </div>
    </div>
</section>

{{-- ====================== CTA ====================== --}}
<section class="section">
    <div class="container-x">
        <div class="cta-box reveal">
            <h2>Siap Modernisasi Laundry-mu?</h2>
            <p>Gratis selamanya untuk paket Starter. Tanpa kartu kredit. Bisa pakai sekarang juga.</p>
            <a href="{{ route('login') }}" class="btn-x">
                Mulai Sekarang Gratis <i data-feather="arrow-right" width="18" height="18"></i>
            </a>
        </div>
    </div>
</section>

{{-- ====================== FOOTER ====================== --}}
<footer class="footer-x">
    <div class="container-x">
        <div class="footer-grid">
            <div>
                <a href="{{ url('/') }}" class="nav-brand" style="margin-bottom: 1rem; display: inline-flex;">
                    <span class="dot"></span>
                    {{ $setpage->judul ?? 'E-Laundry' }}
                </a>
                <p>Aplikasi manajemen laundry modern untuk pelaku usaha laundry di Indonesia. Sederhana, cepat, dan terjangkau.</p>
            </div>
            <div>
                <h5>Produk</h5>
                <ul>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#harga">Harga</a></li>
                    <li><a href="#tracking">Lacak Order</a></li>
                </ul>
            </div>
            <div>
                <h5>Bantuan</h5>
                <ul>
                    <li><a href="#faq">FAQ</a></li>
                    @if(!empty($setpage?->whatsapp))
                        <li><a href="https://wa.me/{{ $setpage->whatsapp }}" target="_blank">WhatsApp</a></li>
                    @endif
                    <li><a href="{{ route('login') }}">Masuk</a></li>
                </ul>
            </div>
            <div>
                <h5>Kontak</h5>
                <ul>
                    @if(!empty($setpage?->alamat))<li>{{ $setpage->alamat }}</li>@endif
                    @if(!empty($setpage?->whatsapp))<li>WA: {{ $setpage->whatsapp }}</li>@endif
                    @if(!empty($setpage?->email))<li>{{ $setpage->email }}</li>@endif
                </ul>
            </div>
        </div>
        <div class="footer-copy">
            &copy; {{ date('Y') }} {{ $setpage->judul ?? 'E-Laundry' }} · Build with <span style="color:var(--danger)">&hearts;</span> by
            <a href="https://www.andridesmana.space" target="_blank">Andri Desmana</a>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).on('click', '#search-btn', function (e) {
    var search_status = $("#search_status").val().trim();
    if (!search_status) {
        Swal.fire({ icon: 'warning', title: 'Kosong', text: 'Masukkan nomor invoice dulu ya.' });
        return;
    }
    $.get('{{ url("pencarian-laundry") }}', {
        '_token': $('meta[name=csrf-token]').attr('content'),
        search_status: search_status
    }, function(resp){
        if (resp && resp != 0) {
            $('#r-customer').text(resp.customer || '-');
            $('#r-tgl').text(resp.tgl_transaksi || '-');
            $('#r-status').text(resp.status_order || '-');
            $('#track-result').addClass('show');
        } else {
            $('#track-result').removeClass('show');
            Swal.fire({ icon: 'error', title: 'Tidak ditemukan', text: 'No invoice tidak terdaftar. Coba cek lagi.' });
        }
    }).fail(function(){
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
    });
});
$(document).on('keypress', '#search_status', function(e) {
    if (e.which === 13) $('#search-btn').click();
});
</script>
@endsection
