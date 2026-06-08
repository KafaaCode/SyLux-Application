<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Country extends Model
{
    use Translatable;

    protected $fillable = [
        'name'
    ];

    // علاقة الدولة بالمستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // علاقة الترجمات
    public function translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }
}
