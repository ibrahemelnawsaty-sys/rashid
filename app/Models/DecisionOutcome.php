<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecisionOutcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'decision_session_id',
        'verdict',
        'affordability_score',
        'recommended_alternative_slugs',
        'cheapest_apr',
        'rationale_ar',
    ];

    protected function casts(): array
    {
        return [
            'affordability_score' => 'decimal:2',
            'recommended_alternative_slugs' => 'array',
            'cheapest_apr' => 'decimal:3',
        ];
    }

    public function decisionSession(): BelongsTo
    {
        return $this->belongsTo(DecisionSession::class);
    }
}
