<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'id_customer','id_karyawan','tgl_transaksi','customer','status_order','status_payment','harga_id','kg','hari','harga','tgl','tgl_ambil','invoice','disc','bulan','tahun','harga_akhir','email_customer'
    ];

    public function harga()
    {
      return $this->belongsTo(harga::class);
    }
}
