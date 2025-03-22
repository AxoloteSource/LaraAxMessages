<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MessageHistory extends Model
{
    /** @use HasFactory<\Database\Factories\MessageHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'message_id',
        'message_status_id',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function messageStatus(): BelongsTo
    {
        return $this->belongsTo(MessageStatus::class);
    }
}
