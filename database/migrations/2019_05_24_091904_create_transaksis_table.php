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
            $table->bigIncrements('id');
            $table->string('invoice');
            $table->string('id_customer');
            $table->string('id_karyawan');
            $table->date('tgl_transaksi');
            $table->string('customer');
            $table->string('status_order');
            $table->string('status_payment');
            $table->string('id_jenis');
            $table->string('kg');
            $table->string('hari');
            $table->string('harga');
            $table->string('tgl');
            $table->date('tgl_ambil')->nullable();
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
