<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(Provider::class)->using(ChannelProvider::class);
    }

    public function channelProvider(): HasMany
    {
        return $this->hasMany(ChannelProvider::class);
    }
}
