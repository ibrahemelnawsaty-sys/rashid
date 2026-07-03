<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'monthly_income_halalas',
        'monthly_expenses_halalas',
        'total_obligations_halalas',
        'dti_ratio',
        'disposable_income_halalas',
        'emergency_fund_halalas',
        'risk_band',
        'computed_at',
    ];

    protected function casts(): array
    {
        return [
            'monthly_income_halalas' => 'integer',
            'monthly_expenses_halalas' => 'integer',
            'total_obligations_halalas' => 'integer',
            'dti_ratio' => 'decimal:2',
            'disposable_income_halalas' => 'integer',
            'emergency_fund_halalas' => 'integer',
            'computed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
