<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBank extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id','nama_bank','no_rekening','nama_pemilik'
    ];

    public function User()
    {
      return $this->belongsTo(User::class);
    }
}
