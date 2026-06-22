<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah field provider WA — biar gateway support lebih dari kirimwa.id.
     * Nilai: kirimwa | fonnte | wablas | wa_cloud
     */
    public function up(): void
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
            $table->string('wa_provider', 20)->default('kirimwa')->after('wa_order_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
            $table->dropColumn('wa_provider');
        });
    }
};
