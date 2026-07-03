<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpenBankingConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_slug',
        'external_connection_id',
        'access_token_encrypted',
        'refresh_token_encrypted',
        'status',
        'consent_id',
        'last_synced_at',
        'expires_at',
    ];

    protected $hidden = [
        'access_token_encrypted',
        'refresh_token_encrypted',
    ];

    protected function casts(): array
    {
        return [
            'access_token_encrypted' => 'encrypted',
            'refresh_token_encrypted' => 'encrypted',
            'last_synced_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class, 'consent_id');
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class, 'connection_id');
    }
}
