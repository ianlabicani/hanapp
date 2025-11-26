<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foodspot_id',
        'rating',
        'comment',
    ];

    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the foodspot being reviewed.
     */
    public function foodspot()
    {
        return $this->belongsTo(Foodspot::class);
    }

    /**
     * Get the masked name of the reviewer for public display.
     * e.g., "John Doe" → "J*** D**"
     */
    public function getMaskedNameAttribute(): string
    {
        if (!$this->user) {
            return 'Anonymous';
        }

        $name = $this->user->name;
        $parts = explode(' ', $name);

        $masked = array_map(function ($part) {
            if (strlen($part) <= 1) {
                return $part;
            }
            return substr($part, 0, 1) . str_repeat('*', strlen($part) - 1);
        }, $parts);

        return implode(' ', $masked);
    }
}
