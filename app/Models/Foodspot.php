<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'images',
        'thumbnail',
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
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating for this foodspot.
     */
    public function averageRating(): ?float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    protected static function booted()
    {
        static::deleting(function (self $foodspot) {
            // delete each image file from the public disk
            $images = $foodspot->images ?? [];
            foreach ($images as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // remove the foodspot directory if it exists
            $dir = 'foodspots/'.$foodspot->id;
            if (Storage::disk('public')->exists($dir) || Storage::disk('public')->directories(dirname($dir))) {
                Storage::disk('public')->deleteDirectory($dir);
            }
        });
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
