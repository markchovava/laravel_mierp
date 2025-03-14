<?php

namespace App\Http\Resources;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'subsidiary' => new SubsidiaryResource($this->whenLoaded('subsidiary')),
            'purchase' => new PurchaseResource($this->whenLoaded('purchase')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
