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
            $table->string('customer_id');
            $table->string('user_id');
            $table->string('tgl_transaksi');
            $table->string('customer');
            $table->string('email_customer');
            $table->enum('status_order',['Process','Done','Delivery'])->default('Process');
            $table->enum('status_payment',['Pending','Success']);
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
