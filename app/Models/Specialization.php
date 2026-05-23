<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Specialization extends Model
{
    use Translatable;

    protected $fillable = [
        'name'
    ];

    // علاقة التخصص بالمستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // علاقة التخصص بالفئات
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // علاقة الترجمات
    public function translations()
    {
        return $this->hasMany(SpecializationTranslation::class);
    }
}
