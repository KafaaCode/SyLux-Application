<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Product extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'category_id',
        'serial_number',
        'description',
        'image',
        'request_number',
        'price',
        'active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة المنتج بتفاصيل الطلبات (اختيارية)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // علاقة الترجمات
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
