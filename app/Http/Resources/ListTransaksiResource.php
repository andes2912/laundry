<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ListTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'invoice'           => $this->invoice,
            'customer_id'       => $this->customer_id,
            'user_id'           => $this->user_id,
            'tgl_transaksi'     => Carbon::parse($this->created_at)->format('l, d F Y / h:i'),
            'customer'          => $this->customer,
            'email_customer'    => $this->email_customer,
            'status_order'      => $this->status_order,
            'status_payment'    => $this->status_payment,
            'jenis_pembayaran'  => $this->jenis_pembayaran,
            'kg'                => $this->kg,
            'harga_akhir'       => number_format($this->harga_akhir),
            'pickup'             => $this->kurirPickup ? [
                'id'        => $this->kurirPickup->id,
                'user_id'   => $this->kurirPickup->user_id,
                'name'      => $this->kurirPickup->kurir->name,
                'status'    => $this->kurirPickup->status
            ] : null,
        ];
    }
}
