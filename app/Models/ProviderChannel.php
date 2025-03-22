<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderChannel extends Model
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
