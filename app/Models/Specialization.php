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

    // علاقة الترجمات
    public function translations()
    {
        return $this->hasMany(SpecializationTranslation::class);
    }
}
