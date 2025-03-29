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
        'default',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }

    public function getDefaultConfigWithChannelProviderByChannelAndProvider(
        int $channelId,
        int $providerId
    ): ?self {
        $table = $this->getTable();

        return $this->select("$table.*", 'cp.id as channel_provider_id')
            ->join('providers as p', function ($query) use ($table) {
                return $query->on('p.id', "$table.provider_id")
                    ->where('p.active', true);
            })->join('channel_providers as cp', function ($query) {
                return $query->on('cp.provider_id', 'p.id')
                    ->where('cp.active', true);
            })->join('channels as c', function ($query) {
                return $query->on('cp.channel_id', 'c.id')
                    ->where('c.active', true);
            })->where("$table.active", true)
            ->where("$table.default", true)
            ->where('p.id', $providerId)
            ->where('c.id', $channelId)
            ->first();
    }
}
