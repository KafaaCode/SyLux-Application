<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationTranslation extends Model
{
    protected $fillable = [
        'specialization_id',
        'locale',
        'name_translated'
    ];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
