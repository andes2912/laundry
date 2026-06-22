<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Strategi:
     * 1. Buat tabel cabangs.
     * 2. Tambah kolom cabang_id (nullable FK) ke users.
     * 3. Backfill: untuk setiap karyawan existing yang sudah punya
     *    nama_cabang/alamat_cabang, buat row Cabang dan link cabang_id.
     */
    public function up(): void
    {
        // 1. Tabel cabangs
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->enum('status', ['Active', 'Not Active'])->default('Active');
            $table->timestamps();
        });

        // 2. cabang_id di users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('cabang_id')->nullable()->after('karyawan_id');
            $table->foreign('cabang_id')->references('id')->on('cabangs')->nullOnDelete();
        });

        // 3. Backfill cabang dari data karyawan existing
        $karyawans = DB::table('users')
            ->where('auth', 'Karyawan')
            ->whereNotNull('nama_cabang')
            ->get(['id', 'nama_cabang', 'alamat_cabang', 'no_telp']);

        foreach ($karyawans as $kry) {
            // Cari cabang yang sudah ada (cocok nama + alamat) untuk hindari duplikat
            $existing = DB::table('cabangs')
                ->where('nama', $kry->nama_cabang)
                ->where('alamat', $kry->alamat_cabang)
                ->first();

            $cabangId = $existing?->id ?? DB::table('cabangs')->insertGetId([
                'nama'       => $kry->nama_cabang,
                'alamat'     => $kry->alamat_cabang,
                'no_telp'    => $kry->no_telp,
                'status'     => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('users')
                ->where('id', $kry->id)
                ->update(['cabang_id' => $cabangId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cabang_id']);
            $table->dropColumn('cabang_id');
        });
        Schema::dropIfExists('cabangs');
    }
};
