<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountBalance extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bank_account_id',
        'balance_halalas',
        'available_halalas',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'balance_halalas' => 'integer',
            'available_halalas' => 'integer',
            'captured_at' => 'datetime',
        ];
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }
}
