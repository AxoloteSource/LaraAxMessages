<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageDetails extends Model
{
    /** @use HasFactory<\Database\Factories\MessageDetailsFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'channel_provider_field_id',
        'message_id',
        'value',
    ];

    public function ChannelProviderField(): BelongsTo
    {
        return $this->belongsTo(ChannelProviderField::class);
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
