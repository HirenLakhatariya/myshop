<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'image',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
