<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'channel_provider_id',
        'created_user_id',
        'message_status_id',
        'attempts',
    ];

    public function channelProvider(): BelongsTo
    {
        return $this->belongsTo(ChannelProvider::class);
    }

    public function messageStatus(): BelongsTo
    {
        return $this->belongsTo(MessageStatus::class);
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

    public function messageDetails()
    {
        return $this->hasMany(MessageDetails::class);
    }

    public function messageHistories()
    {
        return $this->hasMany(MessageHistory::class);
    }
}
