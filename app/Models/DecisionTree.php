<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DecisionTree extends Model
{
    use HasFactory;

    protected $fillable = [
        'version',
        'name',
        'is_active',
        'definition',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'definition' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function decisionSessions(): HasMany
    {
        return $this->hasMany(DecisionSession::class);
    }
}
