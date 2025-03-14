<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'subsidiary_id',
        'name',
        'price',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function subsidiary(){
        return $this->belongsTo(Subsidiary::class, 'subsidiary_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
