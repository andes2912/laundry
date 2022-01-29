<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications_setting extends Model
{
    use HasFactory;

    protected $fillable = [
      'telegram_order_masuk','telegram_order_selesai','email','wa_order_selesai','wa_token'
    ];
}
