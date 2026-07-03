<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DecisionSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'decision_tree_id',
        'purpose',
        'requested_amount_halalas',
        'status',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_amount_halalas' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function decisionTree(): BelongsTo
    {
        return $this->belongsTo(DecisionTree::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(DecisionAnswer::class);
    }

    public function outcome(): HasOne
    {
        return $this->hasOne(DecisionOutcome::class);
    }

    public function financeRequests(): HasMany
    {
        return $this->hasMany(FinanceRequest::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }
}
