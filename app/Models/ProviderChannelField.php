<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderChannelField extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderChannelFieldFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'provider_channel_id',
        'field_id',
        'required',
    ];

    public function providerChannel()
    {
        return $this->belongsTo(ProviderChannel::class, 'provider_channel_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
