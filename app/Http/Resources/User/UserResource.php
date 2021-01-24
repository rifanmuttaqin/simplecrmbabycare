<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $user_id;
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id'           => $this->id,
            'nama'              => $this->nama,
            'nama_penuh'        => $this->nama_penuh,
            'nomor_hp'          => $this->nomor_hp,
            'account_type'      => $this->account_type,
            'profile_picture'   => $this->profile_picture,
            'status'            => $this->status,
            'email'             => $this->email,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
