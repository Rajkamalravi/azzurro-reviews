<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'fingerprint',
        'external_id',
        'rating',
        'review_date',
        'positive_text',
        'negative_text',
        'reviewer_name',
        'reviewer_country',
        'room_type',
        'travel_type',
        'source_url',
        'scraped_at',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'review_date' => 'date',
        'scraped_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function insights(): HasMany
    {
        return $this->hasMany(ReviewInsight::class);
    }
}
