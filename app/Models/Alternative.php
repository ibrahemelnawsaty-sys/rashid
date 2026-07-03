<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'summary_ar',
        'priority',
        'icon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function providers(): HasMany
    {
        return $this->hasMany(AlternativeProvider::class);
    }
}
