<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'sender_email'
    ];
}
