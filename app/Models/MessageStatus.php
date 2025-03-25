<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MessageStatus extends Model
{
    /** @use HasFactory<\Database\Factories\MessageStatusFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function messageHistories(): HasMany
    {
        return $this->hasMany(MessageHistory::class);
    }
}
