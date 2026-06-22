<?php

namespace App\Providers;

use App\Models\notifications_setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Override runtime config dari nilai yang disimpan via dashboard
 * (Settings → Notifikasi). Kalau field belum diisi, fallback ke .env.
 *
 * Aman dijalankan sebelum migrasi: Schema check + try/catch.
 */
class NotificationConfigProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            if (!Schema::hasTable('notifications_settings')) {
                return;
            }
            $cfg = notifications_setting::first();
            if (!$cfg) return;

            // --- SMTP override ---
            if (Schema::hasColumn('notifications_settings', 'mail_host') && $cfg->mail_host) {
                config([
                    'mail.mailers.smtp.host'       => $cfg->mail_host,
                    'mail.mailers.smtp.port'       => (int) ($cfg->mail_port ?: 587),
                    'mail.mailers.smtp.username'   => $cfg->mail_username,
                    'mail.mailers.smtp.password'   => $cfg->mail_password,
                    'mail.mailers.smtp.encryption' => $cfg->mail_encryption ?: null,
                    'mail.default'                 => 'smtp',
                ]);
                if ($cfg->mail_from_address) {
                    config([
                        'mail.from.address' => $cfg->mail_from_address,
                        'mail.from.name'    => $cfg->mail_from_name ?: config('mail.from.name'),
                    ]);
                }
            }

            // --- Telegram bot token override ---
            if (Schema::hasColumn('notifications_settings', 'telegram_bot_token') && $cfg->telegram_bot_token) {
                config(['services.telegram-bot-api.token' => $cfg->telegram_bot_token]);
            }
        } catch (\Throwable $e) {
            // Jangan crash app — log doang.
            \Log::warning('NotificationConfigProvider boot failed: '.$e->getMessage());
        }
    }
}
