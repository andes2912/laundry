<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id'            => $this->id,
            'karyawan_id'   => $this->karyawan_id,
            'name'          => $this->name,
            'email'         => $this->email,
            'auth'          => $this->auth,
            'status'        => $this->status,
            'alamat'        => $this->alamat,
            'no_telp'       => $this->no_telp,
            'point'         => $this->point,
        ];
    }
}
