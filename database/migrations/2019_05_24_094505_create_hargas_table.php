<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hargas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cabang');
            $table->string('jenis');
            $table->string('kg');
            $table->string('harga');
            $table->string('status');
            $table->string('hari');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hargas');
    }
}
