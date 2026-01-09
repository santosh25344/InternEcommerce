<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'amount' => $this->amount,
        ];
    }
}
