<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsContribution extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'savings_plan_id',
        'amount_halalas',
        'source',
        'contributed_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount_halalas' => 'integer',
            'contributed_at' => 'datetime',
        ];
    }

    public function savingsPlan(): BelongsTo
    {
        return $this->belongsTo(SavingsPlan::class);
    }
}
