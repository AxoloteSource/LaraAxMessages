<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageHistory extends Model
{
    /** @use HasFactory<\Database\Factories\MessageHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'message_id',
        'status_id',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function status()
    {
        return $this->belongsTo(MessageStatus::class, 'status_id');
    }
}
