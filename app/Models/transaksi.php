<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class transaksi extends Model
{
    use Notifiable;
    protected $guarded = [];

    public function rawPayload($request)
    {
        $payload['id']                  = $request->id ?? null;
        $payload['invoice']             = "INV-" .  sprintf("%'.03d", $request->id);
        $payload['user_id']             = $request->user_id ?? null;
        $payload['harga_id']            = $request->harga_id ?? null;
        $payload['kg']                  = $request->kg ?? null;
        $payload['hari']                = $request->hari ?? null;
        $payload['harga']               = $request->harga ?? null;
        $payload['disc']                = $request->disc ?? null;
        $payload['harga_akhir']         = $request->harga_akhir ?? null;
        $payload['jenis_pembayaran']    = $request->jenis_pembayaran ?? null;
        $payload['status_order']        = $request->status_order ?? null;
        $payload['status_payment']      = $request->status_payment ?? null;
        $hitung                         = $request->kg * $request->harga;
        if ($request->disc != NULL) {
            $disc                = ($hitung * $request->disc) / 100;
            $total               = $hitung - $disc;
            $request->harga_akhir  = $total;
        } else {
            $payload['harga_akhir']    = $hitung;
        }
        return $payload;
    }

    public function payloadInsert($request)
    {
        $payload = $this->rawPayload($request);
        $payload['customer_id']     = auth()->user()->id;
        $payload['customer']        = auth()->user()->name;
        $payload['email_customer']  = auth()->user()->email;
        $payload['tgl']             = Carbon::now()->day;
        $payload['bulan']           = Carbon::now()->month;
        $payload['tahun']           = Carbon::now()->year;
        $payload['tgl_transaksi']   = Carbon::now()->format('d-m-Y');
        return $payload;
    }

    public function price()
    {
        return $this->belongsTo(harga::class, 'harga_id', 'id');
    }

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id')->where('auth', 'Customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
