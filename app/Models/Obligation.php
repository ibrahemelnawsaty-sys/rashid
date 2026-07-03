<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Obligation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creditor_type',
        'creditor_name',
        'principal_halalas',
        'remaining_halalas',
        'monthly_installment_halalas',
        'apr',
        'months_remaining',
    ];

    protected function casts(): array
    {
        return [
            'principal_halalas' => 'integer',
            'remaining_halalas' => 'integer',
            'monthly_installment_halalas' => 'integer',
            'apr' => 'decimal:3',
            'months_remaining' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
