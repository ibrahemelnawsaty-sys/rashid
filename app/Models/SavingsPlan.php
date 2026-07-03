<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SavingsPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'financial_goal_id',
        'alternative_slug',
        'provider_type',
        'provider_id',
        'target_amount_halalas',
        'monthly_amount_halalas',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_amount_halalas' => 'integer',
            'monthly_amount_halalas' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function financialGoal(): BelongsTo
    {
        return $this->belongsTo(FinancialGoal::class);
    }

    public function provider(): MorphTo
    {
        return $this->morphTo();
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(SavingsContribution::class);
    }
}
