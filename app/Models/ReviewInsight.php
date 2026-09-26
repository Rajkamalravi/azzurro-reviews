<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewInsight extends Model
{
    protected $fillable = [
        'review_id',
        'topic',
        'sentiment',
        'confidence',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
