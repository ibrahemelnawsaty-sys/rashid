<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AlternativeProvider extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'alternative_id',
        'provider_type',
        'provider_id',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class);
    }

    public function provider(): MorphTo
    {
        return $this->morphTo();
    }
}
