<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class transaksi extends Model
{
    use Notifiable;
    protected $fillable = [
        'customer_id','user_id','tgl_transaksi','customer','status_order','status_payment','harga_id','kg','hari','harga','tgl','tgl_ambil','invoice','disc','bulan','tahun','harga_akhir','email_customer','jenis_pembayaran'
    ];

    public function harga()
    {
      return $this->belongsTo(harga::class);
    }
}
