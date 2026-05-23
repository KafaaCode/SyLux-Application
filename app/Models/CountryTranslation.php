<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $fillable = [
        'country_id',
        'locale',
        'name_translated'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
