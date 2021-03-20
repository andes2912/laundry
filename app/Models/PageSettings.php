<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSettings extends Model
{
    use HasFactory;
    protected $fillable = [
      'judul',
      'img_hero',
      'tentang',
      'facebook',
      'instagram',
      'twitter',
      'whatsapp',
      'no_telp',
      'email'
    ];
}
