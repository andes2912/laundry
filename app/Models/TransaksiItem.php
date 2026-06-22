<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiItem extends Model
{
    protected $fillable = [
        'transaksi_id',
        'harga_id',
        'jenis',
        'kg',
        'hari',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'kg'       => 'float',
        'hari'     => 'integer',
        'harga'    => 'integer',
        'subtotal' => 'integer',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(transaksi::class, 'transaksi_id');
    }

    public function harga(): BelongsTo
    {
        return $this->belongsTo(harga::class, 'harga_id');
    }
}
