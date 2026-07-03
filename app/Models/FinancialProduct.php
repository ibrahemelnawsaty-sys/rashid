<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FinancialProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_type',
        'provider_id',
        'name_ar',
        'product_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function provider(): MorphTo
    {
        return $this->morphTo();
    }

    public function aprRates(): HasMany
    {
        return $this->hasMany(AprRate::class);
    }
}
