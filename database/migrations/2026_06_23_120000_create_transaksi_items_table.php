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
     * Buat tabel transaksi_items untuk mendukung 1 order multi-item.
     * Backfill: setiap transaksi existing dipecah menjadi 1 row item.
     *
     * Field transaksi.harga_id/kg/harga/hari/harga_akhir tetap dipertahankan
     * untuk backward-compat (point ke item pertama; harga_akhir = total semua item - disc).
     */
    public function up(): void
    {
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('harga_id')->nullable();
            $table->string('jenis')->nullable();    // snapshot nama jenis (kalau harga dihapus)
            $table->decimal('kg', 8, 2)->default(0);
            $table->integer('hari')->default(0);    // snapshot lama hari
            $table->bigInteger('harga')->default(0);    // harga/kg snapshot
            $table->bigInteger('subtotal')->default(0); // kg * harga
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksis')->cascadeOnDelete();
        });

        // Backfill — setiap transaksi -> 1 item
        $transaksis = DB::table('transaksis')->get();
        foreach ($transaksis as $trx) {
            // Cari jenis dari relasi harga
            $jenis = DB::table('hargas')->where('id', $trx->harga_id)->value('jenis');
            $kg    = (float) $trx->kg;
            $harga = (int) preg_replace('/\D/', '', (string) $trx->harga);
            $subtotal = (int) round($kg * $harga);

            DB::table('transaksi_items')->insert([
                'transaksi_id' => $trx->id,
                'harga_id'     => $trx->harga_id,
                'jenis'        => $jenis,
                'kg'           => $kg,
                'hari'         => (int) ($trx->hari ?: 0),
                'harga'        => $harga,
                'subtotal'     => $subtotal,
                'created_at'   => $trx->created_at,
                'updated_at'   => $trx->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
