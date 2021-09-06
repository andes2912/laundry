<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'nama','alamat','kelamin','no_telp','email_customer'
    ];

    public function transaksi()
    {
      return $this->hasMany(transaksi::class, 'customer_id','id');
    }

    public function users()
    {
      return $this->belongsTo(User::class,'user_id','id');
    }
}
