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
        return $this->belongsToMany(Provider::class, 'provider_channels');
    }

    public function providerChannel(): HasMany
    {
        return $this->hasMany(ProviderChannel::class);
    }
}
