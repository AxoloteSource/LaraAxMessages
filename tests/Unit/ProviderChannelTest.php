<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Provider;
use App\Models\ProviderChannel;
use Tests\TestCase;

class ProviderChannelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider_channel(): void
    {
        $providerChannel = ProviderChannel::factory()->create();
        $this->assertDatabaseHas('provider_channels', [
            'id' => $providerChannel->id,
            'provider_id' => $providerChannel->provider_id,
            'channel_id' => $providerChannel->channel_id,
            'active' => $providerChannel->active,
        ]);
    }

    public function test_it_belongs_to_a_provider()
    {
        $provider = Provider::factory()->create();

        $providerChannel = ProviderChannel::factory()->create(['provider_id' => $provider->id]);

        $this->assertInstanceOf(Provider::class, $providerChannel->provider);
        $this->assertEquals($provider->id, $providerChannel->provider->id);
    }

    public function test_it_belongs_to_a_channel()
    {
        $channel = Channel::factory()->create();

        $providerChannel = ProviderChannel::factory()->create(['channel_id' => $channel->id]);

        $this->assertInstanceOf(Channel::class, $providerChannel->channel);
        $this->assertEquals($channel->id, $providerChannel->channel->id);
    }
}
