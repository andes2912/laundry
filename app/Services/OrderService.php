<?php

namespace App\Services;

use App\Models\harga;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $modelOrder, $modelUser, $modelHarga;

    public function __construct()
    {
        $this->modelOrder   = new transaksi();
        $this->modelUser    = new User();
        $this->modelHarga   = new harga();
    }

    public function order($params)
    {
        try {
            DB::beginTransaction();
            $payloadOrder = $this->modelOrder->payloadInsert($params);

            $order = $this->modelOrder->create($payloadOrder);
            $this->modelOrder->where('id', $order->id)->update([
                'invoice'   => "INV-" .  sprintf("%'.03d", $order->id)
            ]);
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // List Transaksi
    public function listTransaksi()
    {
        $data = $this->modelOrder->where('customer_id', Auth::id())->get();
        return $data;
    }

    // List Laundry
    public function listLaundry()
    {
        $data = $this->modelUser->where('Auth', 'Karyawan')->get();
        return $data;
    }

    // List Harga
    public function listHarga($params)
    {
        $data = $this->modelHarga->where('user_id', $params['user_id'])->where('status', 1)->get();
        return $data;
    }
}
