<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'scope',
        'provider_slug',
        'status',
        'granted_at',
        'expires_at',
        'revoked_at',
        'ip_at_grant',
    ];

    protected function casts(): array
    {
        return [
            'scope' => 'array',
            'granted_at' => 'datetime',
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function openBankingConnections(): HasMany
    {
        return $this->hasMany(OpenBankingConnection::class, 'consent_id');
    }
}
