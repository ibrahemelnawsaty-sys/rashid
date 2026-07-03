<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'decision_session_id',
        'amount_halalas',
        'tenor_months',
        'purpose',
        'best_offer_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount_halalas' => 'integer',
            'tenor_months' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function decisionSession(): BelongsTo
    {
        return $this->belongsTo(DecisionSession::class);
    }

    public function bestOffer(): BelongsTo
    {
        return $this->belongsTo(FinancialProduct::class, 'best_offer_id');
    }
}
