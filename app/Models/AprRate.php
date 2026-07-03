<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AprRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_product_id',
        'apr_min',
        'apr_max',
        'flat_rate',
        'return_rate',
        'admin_fee_halalas',
        'admin_fee_cap_note',
        'min_amount_halalas',
        'max_amount_halalas',
        'min_tenor_months',
        'max_tenor_months',
        'effective_from',
        'effective_to',
        'source',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'apr_min' => 'decimal:3',
            'apr_max' => 'decimal:3',
            'flat_rate' => 'decimal:3',
            'return_rate' => 'decimal:3',
            'admin_fee_halalas' => 'integer',
            'min_amount_halalas' => 'integer',
            'max_amount_halalas' => 'integer',
            'min_tenor_months' => 'integer',
            'max_tenor_months' => 'integer',
            'effective_from' => 'date',
            'effective_to' => 'date',
        ];
    }

    public function financialProduct(): BelongsTo
    {
        return $this->belongsTo(FinancialProduct::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
