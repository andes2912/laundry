# Changelog

Semua perubahan penting pada proyek ini didokumentasikan di sini.
Format mengikuti [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/),
dan proyek ini menggunakan [Semantic Versioning](https://semver.org/lang/id/).

## [4.0.2] — 2026-06-23

Rilis fitur: order multi-item, redesign menyeluruh halaman role, dan pengaturan notifikasi (Email/Telegram/WhatsApp) full lewat dashboard.

### ✨ Added

- **Order multi-item** — satu transaksi bisa berisi beberapa jenis pakaian sekaligus.
  - Tabel baru `transaksi_items` (migration `2026_06_23_120000_create_transaksi_items_table.php`) + backfill data lama jadi 1 item per transaksi.
  - Model `App\Models\TransaksiItem` + relasi `transaksi->items()` di `App\Models\transaksi`.
  - Form Tambah Order ([karyawan/transaksi/addorder.blade.php](resources/views/karyawan/transaksi/addorder.blade.php)) dengan tombol "+ Tambah Item", auto-total kg, lama hari (ambil terlama), subtotal & diskon di kanan sticky.
  - Validasi array `items.*.harga_id` + `items.*.kg` di [AddOrderRequest](app/Http/Requests/AddOrderRequest.php).
  - Field header lama (`harga_id`, `kg`, `harga`, `hari`) tetap dipertahankan untuk backward-compat invoice/laporan lama.
  - Modal **popup detail item** muncul di list order karyawan, list laporan, dashboard customer, detail customer, dan list transaksi admin — kalau >1 item, kolom Jenis berubah jadi tombol "N item · detail".
- **Jenis pembayaran "Belum Diketahui"** — opsi baru selain Tunai/Transfer untuk order yang customer belum menentukan.
  - Ketika karyawan klik "Tandai Lunas" pada order ber-status "Belum Diketahui", muncul modal konfirmasi yang **memaksa pilih Tunai atau Transfer** dulu sebelum AJAX dikirim (radio besar + visual highlight).
- **Konfirmasi update status order** ([karyawan/transaksi/order.blade.php](resources/views/karyawan/transaksi/order.blade.php))
  - Modal konfirmasi sebelum tombol Bayar / Selesai / Diambil dieksekusi, menampilkan info invoice + customer + pesan kontekstual.
  - Tombol konfirmasi otomatis menyesuaikan warna sesuai aksi (merah/biru/kuning).
- **Konfigurasi notifikasi via dashboard** (sebelumnya hanya via `.env`)
  - Migration `2026_06_23_140000_add_dashboard_config_to_notifications_settings.php` menambah kolom: `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `telegram_bot_token`, `wa_gateway_url`, `wa_device_id`.
  - Service provider baru [NotificationConfigProvider](app/Providers/NotificationConfigProvider.php) override `config('mail.*')` dan `config('services.telegram-bot-api.token')` di runtime dari nilai DB; aman kalau tabel/kolom belum ada (Schema check + try/catch).
  - UI Setting → Notifikasi kini punya sub-tab horizontal **Email · Telegram · WhatsApp** dengan badge status: ✓ hijau (aktif & lengkap), ! merah (aktif tapi belum lengkap).
- **Provider preset WhatsApp** — selain Kirimwa.id, sekarang support **Fonnte**, **Wablas**, dan **WA Cloud API (Meta resmi)**.
  - Migration `2026_06_23_150000_add_wa_provider_to_notifications_settings.php` menambah kolom `wa_provider`.
  - Helper `notificationWhatsapp()` ([Model.php](app/Helpers/Model.php)) switch per provider — format auth (Bearer vs raw token), body (JSON vs form-urlencoded), URL default, dan handling Phone Number ID untuk WA Cloud.
  - UI dropdown provider dengan hint berbeda per pilihan + label dinamis (mis. "Device ID" jadi "Phone Number ID *" saat pilih WA Cloud).
- **Cabang** — tabel `cabangs` + model `App\Models\Cabang` (migration `2026_06_22_130000_create_cabangs_table_and_link_users.php`) + controller `Admin\CabangController`. Pondasi untuk multi-outlet.
- **Stat cards & target progress bars** di Finance — pengganti card "Tercapai" lama yang tabrakan warnanya di dark theme. Sekarang badge solid + progress bar % per target hari/bulan/tahun.
- **Sub-menu / sub-tab navigation** di halaman Settings — nav atas pakai horizontal `nav-tabs nav-justified` (sebelumnya pill vertical kiri).
- **Live warning** di form notifikasi — kalau toggle ON tapi field wajib kosong, border field merah + label kuning "Wajib diisi kalau X aktif" muncul real-time. Toggle OFF → warning hilang.
- **Auto-buka tab/sub-tab yang error** setelah submit — kalau validasi server gagal di Email SMTP host, halaman Settings auto-buka tab Notifikasi → sub-tab Email.

### 🎨 Redesigned

Tema konsisten di seluruh role: stat cards + status badges (min-width seragam) + popup detail item + tombol outline dengan icon.

- **List order karyawan** — gabung kolom Status & Bayar jadi 1 (badge dua-baris), kolom Aksi seragam (label lengkap "Tandai Lunas / Selesai / Diambil") + tombol Invoice di bawah; ketika order sudah Delivery+Lunas, ganti jadi badge "Order Selesai ✓".
- **Invoice screen + PDF + admin invoice** — 3 file di-rewrite total: header dengan badge LUNAS/BELUM DIBAYAR, parties Dari/Untuk, tanggal masuk/ambil/jenis pembayaran, tabel item multi-row, summary subtotal/diskon/total. PDF pakai layout table-based (dompdf-safe, tanpa flexbox), portrait A4.
- **Halaman Laporan karyawan** — stat cards (order/kg/omzet/lunas), kolom Pembayaran ditambah, popup detail multi-item. Excel export diubah ke layout flat per item dengan rowspan ke kolom invoice/customer/pembayaran.
- **Dashboard customer** — welcome greeting + point badge, 4 stat cards (order/kg/spent/pending), status pengerjaan 3-kolom, tabel riwayat dengan badge status & pembayaran konsisten.
- **Detail customer karyawan** — kiri profile card (avatar gradient inisial, point, status), kanan 4 stat cards + 3-kolom status pengerjaan + tabel transaksi dengan popup multi-item.
- **Halaman Transaksi admin** — 4 stat cards (total/diproses/belum bayar/omzet), filter karyawan di header, partial blade [`_rows.blade.php`](resources/views/modul_admin/transaksi/_rows.blade.php) baru untuk AJAX rows (sebelumnya string concat) supaya badge & popup tetap konsisten setelah filter.
- **Halaman Finance** — 4 stat cards (hari ini ±%/bulan/tahun/total dengan terbilang), target laundry pakai progress bar (bukan 3 gradient card), list cabang dengan avatar foto + nominal.
- **Halaman Settings** — 5 tab horizontal (General/Target/Tema/Bank/Notifikasi); tema dipilih via 2 kartu visual (Light/Dark mockup) bukan switch; rekening bank dengan kartu gradient ungu.
- **Modal Tambah Rekening Bank** — dengan **live preview kartu** ala kartu kredit (gradient ungu) yang update real-time saat user pilih bank/ketik nomor/nama pemilik.
- **Profile semua role** (Admin/Karyawan/Customer) — layout konsisten: kiri profile card (avatar + role badge + kontak + info akun), kanan form Data Diri + (Cabang khusus karyawan) + Ubah Password. Validasi server seragam.

### 🐛 Fixed

- **Theme toggle 403 untuk role non-Admin** — route `set-theme` sebelumnya di-grup `role:Admin`. Sekarang dipindah keluar (semua role bisa toggle, sesuai intent).
- **Notifikasi unchecked tidak tersimpan** — checkbox tanpa hidden input bikin toggle OFF nggak terkirim ke server. Sekarang tiap switch punya `<input type="hidden" value="0">` + controller pakai `$request->boolean()` untuk normalisasi.
- **`telegram_channel_selesai` salah reuse `masuk`** — sebelumnya controller selalu assign nilai channel masuk ke field selesai. Sekarang field terpisah di UI; fallback ke masuk hanya kalau selesai kosong.
- **`ProfileController` karyawan**:
  - `Hash` facade tidak di-import → fatal error saat user ganti password. Sudah di-import.
  - `$nama_foto` referenced di luar scope assignment.
  - `no_telp` tidak ikut disimpan.
  - Tambahan validasi `name` / `email` / `foto` (max 2MB) / `password` (min 6 + confirmed).
- **`AdminController@edit_profile`** sebelumnya cuma update name & email via AJAX modal. Sekarang full form di halaman: validasi + upload foto + ubah password + simpan no_telp/alamat. Route diubah dari GET → PUT `profile-admin/update`.
- **Blade `@json()` paren-matching bug** — Blade compiler salah hitung tutup kurung saat ada cast `(int)`/`(float)` di dalam `@json(...)` arrow fn. Workaround: pre-compute array ke variabel `@php` block dulu, lalu `{{ json_encode($var) }}` di attribute. Diterapkan di list order, laporan, dashboard customer, detail customer, list transaksi admin.
- **Helper `notificationWhatsapp()`** — sebelumnya tidak ada try/catch dan device_id hardcoded `'iphone'`. Sekarang ada timeout 10s + error handling + return result `['ok','code','body','provider']`.
- **CSS hilang di tabel transaksi admin** — tabel kehilangan kelas `display` (DataTables butuh ini untuk styling default). Sudah ditambahkan.
- **Badge "Tercapai" tabrakan di dark theme** — `badge-light-success` nyaris invisible di card body. Diganti `badge-success` (solid).

### 🔧 Changed

- **`Admin\TransaksiController@filtertransaksi`** — sebelumnya render HTML string via concat. Sekarang render via partial blade `_rows.blade.php` (DRY, mendukung badge & multi-item popup tanpa duplikasi kode).
- **`Admin\SettingsController@notif`** — validasi komprehensif: toggle ON tapi config wajib kosong → `back()->withErrors(...)` per field. Password SMTP tidak ditimpa kalau field dibiarkan kosong (preserve nilai existing).
- **Eager-load `items` + `price`** di semua controller yang menampilkan list transaksi (Karyawan/Admin Pelayanan/Invoice/Laporan/Customer/Home + LaporanExport) — menghindari N+1.
- **PDF invoice karyawan** dari landscape → portrait (lebih invoice-like).
- **Helper `setNotificationEmail`** dst. tetap dipakai sebagai gate di controller order; output controller tidak berubah.

### 📦 Migrations

- `2026_06_22_130000_create_cabangs_table_and_link_users.php`
- `2026_06_23_120000_create_transaksi_items_table.php` (+ backfill)
- `2026_06_23_140000_add_dashboard_config_to_notifications_settings.php`
- `2026_06_23_150000_add_wa_provider_to_notifications_settings.php`

### 🚀 Upgrade

```bash
php artisan migrate
php artisan config:clear
php artisan view:clear
```

Setelah migrate, buka **Settings → Notifikasi** untuk pindahkan kredensial SMTP/Telegram bot token/WA gateway dari `.env` ke dashboard kalau diinginkan. Nilai di DB akan override `.env` di runtime; kalau dikosongkan, fallback ke `.env`.

---

## [4.0.1] — 2026-06-22

Rilis besar: upgrade framework Laravel 9 → 12, redesign dashboard admin, dan landing page baru dengan tema dark default.

### ✨ Added

- **Dark/Light theme dengan default dark**
  - Migration baru `2026_06_22_120000_set_default_dark_theme_in_users_table.php` mengubah default kolom `users.theme` menjadi `1` (dark) dan mem-backfill user existing.
  - Tombol toggle sun/moon di navbar backend (`layouts/backend.blade.php`), submit form ke route existing `setting-theme.update`.
  - Halaman auth (login) sekarang dark-layout permanen.
- **Landing page baru** (`resources/views/frontend/index-dashboard.blade.php` + `layouts/frontend-dashboard.blade.php`)
  - Navbar sticky dengan backdrop blur, brand dot indicator, nav links.
  - Hero section dengan tracking invoice langsung di hero (hasil ditampilkan inline, bukan modal).
  - 8 fitur card dengan icon ber-warna (primary/success/info/warning/danger) mengikuti palette dashboard.
  - 3 langkah "Cara Kerja".
  - 3 tier pricing (Starter Gratis · Pro Rp 99rb · Business Rp 249rb).
  - 3 kartu testimoni.
  - 6 item FAQ accordion (vanilla JS).
  - Section CTA gradient + footer multi-kolom.
  - WhatsApp floating button.
  - Toggle dark/light di-persist via `localStorage`.
- **Admin dashboard redesign** (`resources/views/modul_admin/index.blade.php`)
  - Greeting time-aware ("Selamat Pagi / Siang / Sore / Malam" + nama depan user).
  - 3 quick action buttons: Transaksi Baru, Karyawan, Customer.
  - 4 stat card dengan label sub-info (terdaftar, dalam proses, dst).
  - Revenue summary 5-kolom: Hari ini · Kemarin · Bulan · Tahun · Tahun lalu.
  - Card "Status Pembayaran" dengan progress bar % lunas vs belum bayar.
  - Tabel "Transaksi Terbaru" (8 transaksi terakhir).
  - Chart harian & bulanan sekarang theme-aware (warna grid menyesuaikan dark/light).
- **`HomeController@index`** menambah variable `$recent` (8 transaksi terakhir) untuk dashboard admin.
- **Mobile UX landing page**
  - Section Fitur, Cara Kerja, Harga, Testimoni jadi horizontal scroll dengan `scroll-snap` di viewport ≤768px.
  - Setiap card peek ~80% lebar viewport.
  - Swipe hint "← Geser untuk lihat semua →" muncul otomatis di mobile.
  - Hero content center-aligned di mobile, track card padding & layout disesuaikan.

### 🔄 Changed

- **Laravel framework: `^9.0` → `^12.0`** (saat ini 12.62.0). Minimum PHP `^8.0.21` → `^8.2` (rekomendasi 8.3).
- **Dependency utama:**
  - `laravel/tinker`: `^2.6.3` → `^2.9`
  - `laravel/ui`: `^3.0` → `^4.6`
  - `barryvdh/laravel-dompdf`: `^2.0` → `^3.0`
  - `laravel-notification-channels/telegram`: `^2.1` → `^6.0`
  - `spatie/laravel-permission`: `^5.5.5` → `^6.9`
  - `maatwebsite/excel`: `^3.1` → `^3.1.55`
  - `realrashid/sweet-alert`: `^5.1.0` → `^7.2`
  - `guzzlehttp/guzzle`: `^7.4` → `^7.8`
  - `andes2912/indobank`: `^0.7.0` → `^0.9`
- **Dependency dev:**
  - `phpunit/phpunit`: `^9.0` → `^11.0`
  - `nunomaduro/collision`: `^6.1` → `^8.1`
  - `mockery/mockery`: `^1.0` → `^1.6`
  - Ditambah `laravel/pint` untuk code style.
- `minimum-stability`: `dev` → `stable`.
- Hapus `classmap` legacy di `composer.json` autoload (Laravel 12 sudah tidak perlu).
- `FrontController@index` sekarang render view baru `frontend.index-dashboard`.

### 🐛 Fixed

- **Breaking change spatie/laravel-permission v6**: namespace middleware berubah dari `Spatie\Permission\Middlewares\` (plural) → `Spatie\Permission\Middleware\` (singular). Diperbaiki di `app/Http/Kernel.php` untuk alias `role`, `permission`, dan `role_or_permission`. Memperbaiki error `Target class [Spatie\Permission\Middlewares\RoleMiddleware] does not exist` saat akses `/karyawan`.
- **Hero pill mobile tidak simetris**: text "Notifikasi WhatsApp otomatis…" sebelumnya overflow / tidak rata. Sekarang `white-space: normal`, font 0.78rem, center-aligned.
- **Track card mobile tidak simetris**: padding 2rem → 1.25rem, input + button stack vertical penuh-lebar, alignment kiri rapi.
- **Chart dashboard** sebelumnya selalu pakai warna grid light meskipun di dark mode. Sekarang otomatis pakai warna sesuai theme aktif.

### 🗑️ Removed

- `laravelcollective/html` — tidak dipakai di codebase (sudah di-grep, tidak ada `Form::` atau `Html::`).
- `fzaninotto/faker` — package abandoned. Diganti `fakerphp/faker` di require-dev.
- `beyondcode/laravel-dump-server` — sudah deprecated, fungsinya digantikan `laravel/pint` & Telescope.
- Route `/landing-v2` preview (sudah jadi route utama).

### ⚠️ Breaking Changes / Migration Path

Untuk yang melakukan pull dari rilis sebelumnya:

```bash
# Pastikan PHP minimal 8.2 (rekomendasi 8.3)
php -v

# Install ulang dependencies
composer install

# Jalankan migration baru (default dark theme + backfill)
php artisan migrate

# Clear cache
php artisan optimize:clear
```

**Catatan compat:**
- Jika menggunakan `Spatie\Permission\Middlewares\*` di custom code, ganti ke `Spatie\Permission\Middleware\*` (singular).
- View lama (`frontend/index.blade.php`, `frontend/banner.blade.php`, `frontend/content.blade.php`, `frontend/header.blade.php`, `frontend/footer.blade.php`, `frontend/modal.blade.php`, `layouts/frontend.blade.php`) sekarang tidak dipakai. Boleh dihapus untuk kebersihan, atau dibiarkan sebagai backup.
- `database/factories/UserFactory.php` masih bergaya Laravel 7 (`$factory->define(...)`). Belum di-port ke class-based factory karena tidak dipakai di test mana pun saat ini. Jika perlu menulis test/seed yang pakai factory, perlu refactor manual ke `extends Factory`.

### 📦 Versi

| Komponen | Sebelum | Sesudah |
|---|---|---|
| Laravel | 9.x | 12.62.0 |
| PHP | 8.0.21+ | 8.2+ (rekomendasi 8.3) |
| spatie/laravel-permission | 5.5 | 6.9 |
| barryvdh/laravel-dompdf | 2.0 | 3.0 |
| PHPUnit | 9 | 11 |

---

## [< 4.0.1] — Sebelumnya

Riwayat sebelum upgrade ini tidak terdokumentasi di file changelog.
