<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    // علاقة تفاصيل الطلب بالطلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة تفاصيل الطلب بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
