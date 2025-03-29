<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ChannelProviderField extends Model
{
    /** @use HasFactory<\Database\Factories\ChannelProviderFieldFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'channel_provider_id',
        'field_id',
        'required',
    ];

    public function channelProvider(): BelongsTo
    {
        return $this->belongsTo(ChannelProvider::class, 'channel_provider_id');
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function provider(): HasOneThrough
    {
        return $this->hasOneThrough(
            Provider::class,
            ChannelProvider::class,
            'id',
            'id',
            'channel_provider_id',
            'provider_id'
        );
    }

    public function channel(): HasOneThrough
    {
        return $this->hasOneThrough(
            Channel::class,
            ChannelProvider::class,
            'id',
            'id',
            'channel_provider_id',
            'channel_id'
        );
    }

    public function getByChannelProviderId(
        int $channelProviderId
    ): Collection {
        return $this->with('field')
            ->where('channel_provider_id', $channelProviderId)
            ->get();
    }
}
