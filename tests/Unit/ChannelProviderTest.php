<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelProvider;
use App\Models\Provider;
use Tests\TestCase;

class ChannelProviderTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_channel_provider(): void
    {
        $channelProvider = ChannelProvider::factory()->create();
        $this->assertDatabaseHas('channel_providers', [
            'id' => $channelProvider->id,
            'provider_id' => $channelProvider->provider_id,
            'channel_id' => $channelProvider->channel_id,
            'active' => $channelProvider->active,
        ]);
    }

    public function test_it_belongs_to_a_provider()
    {
        $provider = Provider::factory()->create();

        $channelProvider = ChannelProvider::factory()->create(['provider_id' => $provider->id]);

        $this->assertInstanceOf(Provider::class, $channelProvider->provider);
        $this->assertEquals($provider->id, $channelProvider->provider->id);
    }

    public function test_it_belongs_to_a_channel()
    {
        $channel = Channel::factory()->create();

        $channelProvider = ChannelProvider::factory()->create(['channel_id' => $channel->id]);

        $this->assertInstanceOf(Channel::class, $channelProvider->channel);
        $this->assertEquals($channel->id, $channelProvider->channel->id);
    }
}
