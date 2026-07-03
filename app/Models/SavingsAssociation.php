<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SavingsAssociation extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'legal_mechanism',
        'admin_fee_halalas',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'admin_fee_halalas' => 'integer',
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
