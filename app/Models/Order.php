<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'delivery_time',
        'reply_message',
        'status',
        'total_price'
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->serial_number)) {
                $order->serial_number = 'ORD' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
