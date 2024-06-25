<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'address' => $this->address,
            'city'=> $this->city,
            'state'=> $this->state,
            'type' => $this->type,
            'postalCode'=> $this->postal_code,

            // `whenLoaded` this is a way of conditioning include the invoice model to customer
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
        ];
    }
}
