<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTokenWaToNotificationsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
          $table->boolean('wa_order_selesai')->after('telegram_channel_selesai');
          $table->string('wa_token')->after('wa_order_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
            //
        });
    }
}
