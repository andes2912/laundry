<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListHargaLaundryResource extends JsonResource
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
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'jenis'     => $this->jenis . ' - ' . 'Rp.' . $this->harga . ' - ' . $this->hari . ' hari',
            'harga'     => $this->harga,
            'hari'      => $this->hari
        ];
    }
}
