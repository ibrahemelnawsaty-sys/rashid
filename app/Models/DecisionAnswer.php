<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecisionAnswer extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'decision_session_id',
        'node_key',
        'answer',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'answer' => 'array',
            'weight' => 'decimal:2',
        ];
    }

    public function decisionSession(): BelongsTo
    {
        return $this->belongsTo(DecisionSession::class);
    }
}
