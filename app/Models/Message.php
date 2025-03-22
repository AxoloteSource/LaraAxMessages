<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provider_channel_id',
        'created_user_id',
        'status_id',
        'attempts',
    ];

    public function providerChannel(): BelongsTo
    {
        return $this->belongsTo(ProviderChannel::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(MessageStatus::class, 'status_id');
    }
}
