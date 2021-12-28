<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class harga extends Model
{
    protected $fillable = [
        'user_id','jenis','kg','harga','status','harga','hari'
    ];

    public function transaksi()
    {
      return $this->hasMany(transaksi::class);
    }

    public function harga_user()
    {
      return $this->belongsTo(User::class,'user_id','id');
    }
}
