<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProviderConfig extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderConfigFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'provider_id',
        'name',
        'active',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }
}
