<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'subsidiary_id',
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'total',
        'created_at',
        'updated_at',
    ];


    public function subsidiary(){
        return $this->belongsTo(Subsidiary::class, 'subsidiary_id', 'id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
