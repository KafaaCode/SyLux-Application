<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'title',
        'message',
        'sender_name',
        'sender_email'
    ];
}
