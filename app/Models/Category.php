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
        'section_id',
        'country_id',
        'specialization_id',
        'active'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // علاقة الفئة بالدولة
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // علاقة الفئة بالتخصص
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    // علاقة الترجمات
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}
