<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'name' => $this->name,
            'shop_name' => $this->shop_name,
            'contact' => $this->contact,
            'email' => $this->email,
            'address' => $this->address,
            'logo' => $this->logo,
            'status' => $this->status,
            'expire_date' => $this->expire_date,
        ];
    }
}
