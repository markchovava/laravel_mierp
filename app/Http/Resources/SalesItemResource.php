<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesItemResource extends JsonResource
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
            'product_id' => $this->product_id,
            'sales_id' => $this->sales_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'subsidiary' => new SubsidiaryResource($this->whenLoaded('subsidiary')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'sales' => new SalesResource($this->whenLoaded('sales')),
        ];
    }
}
