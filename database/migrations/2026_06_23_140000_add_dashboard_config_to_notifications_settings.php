<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan field-field konfigurasi notifikasi yang bisa diatur via dashboard:
     * - SMTP (mail_*) — kalau diisi, override config('mail.*') saat runtime
     * - Telegram bot token — override config('services.telegram-bot-api.token')
     * - WhatsApp gateway URL & device_id — dipakai helper notificationWhatsapp()
     *
     * Semua field bersifat opsional; kalau kosong, fallback ke env / default.
     */
    public function up(): void
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
            // Email SMTP
            $table->string('mail_host')->nullable()->after('email');
            $table->unsignedSmallInteger('mail_port')->nullable()->after('mail_host');
            $table->string('mail_username')->nullable()->after('mail_port');
            $table->string('mail_password')->nullable()->after('mail_username');
            $table->string('mail_encryption', 10)->nullable()->after('mail_password'); // tls / ssl / null
            $table->string('mail_from_address')->nullable()->after('mail_encryption');
            $table->string('mail_from_name')->nullable()->after('mail_from_address');

            // Telegram bot token
            $table->string('telegram_bot_token')->nullable()->after('telegram_channel_selesai');

            // WhatsApp gateway
            $table->string('wa_gateway_url')->nullable()->after('wa_token');
            $table->string('wa_device_id', 50)->nullable()->after('wa_gateway_url');
        });
    }

    public function down(): void
    {
        Schema::table('notifications_settings', function (Blueprint $table) {
            $table->dropColumn([
                'mail_host','mail_port','mail_username','mail_password','mail_encryption',
                'mail_from_address','mail_from_name',
                'telegram_bot_token',
                'wa_gateway_url','wa_device_id',
            ]);
        });
    }
};
