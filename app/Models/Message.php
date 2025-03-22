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

    public function providerChannel(): BelongsTo
    {
        return $this->belongsTo(ProviderChannel::class);
    }

    public function messageStatus(): BelongsTo
    {
        return $this->belongsTo(MessageStatus::class);
    }

    public function provider(): HasOneThrough
{
    return $this->hasOneThrough(
        Provider::class,         
        ProviderChannel::class,   
        'provider_id',            
        'id',                    
        'channel_provider_id',    
        'id'                     
    );
}

public function channel(): HasOneThrough
{
    return $this->hasOneThrough(
        Channel::class,
        ProviderChannel::class,
        'channel_id',           
        'id',                   
        'channel_provider_id',  
        'id'                   
    );
}
}
