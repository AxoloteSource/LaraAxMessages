<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'active',
    ];

    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class)->using(ProviderChannel::class);
    }

    public function providerChannel(): HasMany
    {
        return $this->hasMany(ProviderChannel::class);
    }
}
