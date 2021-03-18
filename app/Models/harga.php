<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class harga extends Model
{
    protected $fillable = [
        'id_cabang','jenis','kg','harga','status','harga','hari'
    ];

    public function transaksi()
    {
      return $this->belongsTo('App\Models\transaksi','harga_id');
    }
}
