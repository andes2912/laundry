<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailTransaksiResource extends JsonResource
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
            'tgl_transaksi'     => $this->tgl_transaksi,
            'laundry'           => $this->user->nama_cabang,
            'alamat_laundry'    => $this->user->alamat_cabang,
            'customer'          => $this->customer,
            'email_customer'    => $this->email_customer,
            'alamat_customer'   => $this->customers->alamat,
            'status_order'      => $this->status_order,
            'status_payment'    => $this->status_payment,
            'jenis_pembayaran'  => $this->jenis_pembayaran,
            'kg'                => $this->kg,
            'harga_akhir'       => number_format($this->harga_akhir),
            'bukti_pembayaran'  => $this->bukti_pembayaran != null ? true : false,
            'jenis'             => $this->price->jenis,
            'pickup'             => $this->kurirPickup ? [
                'id'        => $this->kurirPickup->id,
                'user_id'   => $this->kurirPickup->user_id,
                'name'      => $this->kurirPickup->kurir->name,
                'status'    => $this->kurirPickup->status
            ] : null,
        ];
    }
}
