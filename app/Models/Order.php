<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_id','number', 'total_amount', 'status'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_id = 'ORD-' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    public function items()
    {
        return $this->hasMany(Orderitem::class, 'order_id', 'order_id'); 
    }
}
