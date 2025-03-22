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
        'provider_channel_field_id',
        'message_id',
        'value',
    ];

    public function providerChannelField(): BelongsTo
    {
        return $this->belongsTo(ProviderChannelField::class, 'provider_channel_field_id');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
