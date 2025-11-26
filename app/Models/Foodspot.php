<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foodspot extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'description',
        'open_time',
        'close_time',
        'visits',
        'contact_number',
        'email',
        'category_tag',
        'latitude',
        'longitude',
        'tagline',
        'category',
    ];

    protected $casts = [
        'visits' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'open_time' => 'string',
        'close_time' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

/*
name
address
description
open_time
close_time
visits
contact_number
email
category_tag
latitude
longitude
tagline
category // panciteria, cafe, Restaurant, Hotel
*/
