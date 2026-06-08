<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'image',
        'active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
