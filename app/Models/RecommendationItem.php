<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RecommendationItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'recommendation_id',
        'alternative_slug',
        'provider_type',
        'provider_id',
        'rank',
        'projected_cost_halalas',
        'projected_saving_halalas',
        'reason_ar',
        'cta_route',
    ];

    protected function casts(): array
    {
        return [
            'rank' => 'integer',
            'projected_cost_halalas' => 'integer',
            'projected_saving_halalas' => 'integer',
        ];
    }

    public function recommendation(): BelongsTo
    {
        return $this->belongsTo(Recommendation::class);
    }

    public function provider(): MorphTo
    {
        return $this->morphTo();
    }
}
