<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'id_customer','id_karyawan','tgl_transaksi','customer','status_order','status_payment','id_jenis','kg','hari','harga','tgl','tgl_ambil','invoice','notif','disc'
    ];
}
