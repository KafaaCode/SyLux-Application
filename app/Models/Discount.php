<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'discount_percentage',
        'active',
        'start_time',
        'end_time',
        'apply_to_all',
    ];

    protected $casts = [
        'active' => 'boolean',
        'apply_to_all' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product');
    }
}
