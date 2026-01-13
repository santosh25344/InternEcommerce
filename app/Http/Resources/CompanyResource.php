<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'owner_name' => $this->owner_name,
            'company_name' => $this->company_name,
            'contact' => $this->contact,
            'email' => $this->email,
            'password' => $this->password,
            'address' => $this->address,
            'logo' => $this->logo,
            'status' => $this->status,
            'expire_date' => $this->expire_date,
            'play_store_link' => $this->play_store_link,
            'app_store_link' => $this->app_store_link,
        ];
    }
}
