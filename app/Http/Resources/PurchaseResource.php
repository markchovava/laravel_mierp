<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'subsidiary_id' => $this->subsidiary_id,
            'total' => $this->total,
            'quantity' => $this->quantity,
            'supplier_name' => $this->supplier_name,
            'supplier_phone' => $this->supplier_phone,
            'supplier_address' => $this->supplier_address,
            'supplier_email' => $this->supplier_email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'subsidiary' => new SubsidiaryResource($this->whenLoaded('subsidiary')),
            'purchase_items' => PurchaseItemResource::collection($this->whenLoaded('purchase_items')),
        ];
    }
}
