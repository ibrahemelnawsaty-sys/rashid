<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class InvestmentApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'type',
        'management_fee',
        'target_return',
        'min_amount_halalas',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'management_fee' => 'decimal:3',
            'target_return' => 'decimal:2',
            'min_amount_halalas' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function financialProducts(): MorphMany
    {
        return $this->morphMany(FinancialProduct::class, 'provider');
    }

    public function alternativeProviders(): MorphMany
    {
        return $this->morphMany(AlternativeProvider::class, 'provider');
    }
}
