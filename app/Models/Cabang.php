<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'status',
    ];

    /**
     * Karyawan yang bekerja di cabang ini.
     */
    public function karyawan(): HasMany
    {
        return $this->hasMany(User::class, 'cabang_id', 'id')
            ->where('auth', 'Karyawan');
    }
}
