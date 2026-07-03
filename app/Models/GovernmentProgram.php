<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class GovernmentProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'authority',
        'category',
        'max_amount_halalas',
        'max_tenor_months',
        'interest_free',
        'details_ar',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_amount_halalas' => 'integer',
            'max_tenor_months' => 'integer',
            'interest_free' => 'boolean',
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
