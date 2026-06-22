<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications_setting extends Model
{
    use HasFactory;

    protected $fillable = [
      'telegram_order_masuk','telegram_order_selesai','email','wa_order_selesai','wa_token',
      'telegram_channel_masuk','telegram_channel_selesai','telegram_bot_token',
      'mail_host','mail_port','mail_username','mail_password','mail_encryption',
      'mail_from_address','mail_from_name',
      'wa_gateway_url','wa_device_id','wa_provider',
    ];

    protected $hidden = ['mail_password'];
}
