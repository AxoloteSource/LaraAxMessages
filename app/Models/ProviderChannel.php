<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProviderChannel extends Pivot
{
    /** @use HasFactory<\Database\Factories\ProviderChannelFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'provider_id',
        'channel_id',
        'active',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
