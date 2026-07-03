<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FinanceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'name_en',
        'category',
        'sama_licensed',
        'logo_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sama_licensed' => 'boolean',
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
