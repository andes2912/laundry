# Changelog

Semua perubahan penting pada proyek ini didokumentasikan di sini.
Format mengikuti [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/),
dan proyek ini menggunakan [Semantic Versioning](https://semver.org/lang/id/).

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
