<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class harga extends Model
{
    protected $fillable = [
        'id_cabang','jenis','kg','harga','status','harga','hari'
    ];
}
