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

    /**
     * Normalize images attribute to a flat array of string paths.
     */
    public function getImagesAttribute($value)
    {
        $images = $value;

        if (is_string($images)) {
            $decoded = json_decode($images, true);
            if (is_array($decoded)) {
                $images = $decoded;
            }
        }

        if (!is_array($images)) {
            return [];
        }

        $out = [];
        foreach ($images as $img) {
            if (is_array($img)) {
                $path = $img['path'] ?? $img['file'] ?? $img['filename'] ?? $img['url'] ?? null;
                if (is_string($path) && trim($path) !== '') {
                    $out[] = $path;
                }
            } elseif (is_string($img)) {
                // ignore JSON-array-like strings
                if (preg_match('/^\s*\[.*\]\s*$/', $img)) {
                    continue;
                }
                if (trim($img) !== '') {
                    $out[] = $img;
                }
            }
        }

        return array_values(array_filter($out));
    }

    /**
     * Normalize thumbnail attribute to a single string path or null.
     */
    public function getThumbnailAttribute($value)
    {
        $thumb = $value;

        if (is_array($thumb)) {
            $thumb = $thumb['path'] ?? $thumb['file'] ?? $thumb['filename'] ?? $thumb['url'] ?? null;
        }

        if (is_string($thumb) && preg_match('/^\s*\[.*\]\s*$/', $thumb)) {
            return null;
        }

        return is_string($thumb) && trim($thumb) !== '' ? $thumb : null;
    }

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
