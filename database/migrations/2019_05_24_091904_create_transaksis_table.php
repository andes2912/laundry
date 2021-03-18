<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('id_customer');
            $table->string('id_karyawan');
            $table->string('tgl_transaksi');
            $table->string('customer');
            $table->string('email_customer');
            $table->string('status_order');
            $table->string('status_payment');
            $table->integer('harga_id');
            $table->string('kg');
            $table->string('hari');
            $table->string('harga');
            $table->string('disc')->nullable();
            $table->string('harga_akhir')->nullable();
            $table->string('tgl');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('tgl_ambil')->nullable();
            $table->string('notif')->default(0);
            $table->string('notif_admin')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
