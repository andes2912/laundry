<?php

namespace App\Services;

use App\Helpers\ClientResponderHelper;
use App\Http\Resources\DetailLaundryResource;
use App\Http\Resources\DetailTransaksiResource;
use App\Http\Resources\ListHargaLaundryResource;
use App\Http\Resources\ListLaundryResource;
use App\Http\Resources\ListTransaksiResource;
use App\Models\harga;
use App\Models\KurirPickup;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    use ClientResponderHelper;

    protected $modelOrder, $modelUser, $modelHarga, $modelPickup;

    public function __construct()
    {
        $this->modelOrder   = new transaksi();
        $this->modelUser    = new User();
        $this->modelHarga   = new harga();
        $this->modelPickup  = new KurirPickup();
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
            DB::rollBack();
            return $this->responseFailed($th->getMessage());
        }
    }

    // Detail Laundry
    public function detailLaundry($id)
    {
        $data = $this->modelUser->findOrFail($id);
        return new DetailLaundryResource($data);
    }

    // List Transaksi
    public function listTransaksi($params)
    {
        $status_payment = $params['status_payment'];
        $status_order = $params['status_order'];

        $data = $this->modelOrder->where('customer_id', Auth::id())
            ->when($status_payment, function ($payment) use ($status_payment) {
                $payment->where('status_payment', $status_payment);
            })
            ->when($status_order, function ($payment) use ($status_order) {
                $payment->where('status_order', $status_order);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
        return ListTransaksiResource::collection($data);
    }

    // List Transaksi
    public function listTransaksiKurir()
    {
        $data = $this->modelOrder->Where('user_id', Auth::user()->karyawan_id)
            ->where('status_payment', 'pending')
            ->orderBy('updated_at', 'desc')
            ->get();
        return ListTransaksiResource::collection($data);
    }

    // Detail Transaksi
    public function detailTransaksi($id)
    {
        $data = $this->modelOrder->findOrFail($id);
        return new DetailTransaksiResource($data);
    }

    // List Laundry
    public function listLaundry($params)
    {
        $limit = ($params['limit'] == -1) ? 9999999 : $params['limit'];

        $data = $this->modelUser->where('Auth', 'Karyawan')->limit($limit)
            ->paginate($limit);
        return ListLaundryResource::collection($data);
    }

    // List Harga
    public function listHarga($params)
    {
        $data = $this->modelHarga->where('user_id', $params['user_id'])->where('status', 1)->get();
        return  ListHargaLaundryResource::collection($data);
    }

    // Pickup Laundry
    public function pickupLaundry($params)
    {
        try {
            DB::beginTransaction();
            $payload = $this->modelPickup->payloadInsert($params);
            $pickup = $this->modelPickup->updateOrCreate(['transaksi_id' => $params['transaksi_id']], $payload);
            DB::commit();
            return $pickup;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseFailed($th->getMessage());
        }
    }

    // Payment
    public function payment($params)
    {
        try {
            DB::beginTransaction();
            $data = transaksi::where('id', $params['transaksi_id'])->first();
            if ($params['bukti_pembayaran']) {
                $bukti = $params->file('bukti_pembayaran');
                $bukti_file = $data->invoice . "-" . time() . "." . $bukti->getClientOriginalExtension();
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'public/file/bukti';
                $bukti->storeAs($tujuan_upload, $bukti_file);
            }

            $data->bukti_pembayaran = $bukti_file;
            $data->update();

            DB::commit();
            return $data;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseFailed($th->getMessage());
        }
    }
}
