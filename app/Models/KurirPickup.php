<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KurirPickup extends Model
{
    use HasFactory;

    protected $table = 'kurir_pickup';
    protected $guarded = [];

    public function rawPayload($request)
    {
        $payload['id']                  = $request->id ?? null;
        $payload['transaksi_id']        = $request->transaksi_id ?? null;
        $payload['status']              = $request->status ?? null;
        return $payload;
    }

    public function payloadInsert($request)
    {
        $payload = $this->rawPayload($request);
        $payload['user_id'] = Auth::id();
        return $payload;
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
