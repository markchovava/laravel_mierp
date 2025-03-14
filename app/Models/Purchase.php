<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'subsidiary_id',
        'total',
        'quantity',
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'supplier_email',
        'created_at',
        'updated_at'
    ];

    public function subsidiary(){
        return $this->belongsTo(Subsidiary::class, 'subsidiary_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function purchase_items(){
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id');
    }

   
}
