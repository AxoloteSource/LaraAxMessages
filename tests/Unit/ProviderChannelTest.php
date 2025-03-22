<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Provider;
use App\Models\ProviderChannel;
use App\Models\ChannelProviderField;
use Tests\TestCase;

class ProviderChannelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider_channel(): void
    {
        $providerChannel = ProviderChannel::factory()->create();
        $this->assertDatabaseHas('channel_provider', [
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

    public function test_it_can_retrieve_provider_through_provider_channel_field()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $providerChannel = ProviderChannel::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $ChannelProviderField = ChannelProviderField::factory()->create([
            'channel_provider_id' => $providerChannel->id,
        ]);

        $retrievedProvider = $ChannelProviderField->provider;

        $this->assertInstanceOf(Provider::class, $retrievedProvider);
        $this->assertEquals($provider->id, $retrievedProvider->id);
    }

    public function test_it_can_retrieve_channel_through_provider_channel_field()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $providerChannel = ProviderChannel::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $ChannelProviderField = ChannelProviderField::factory()->create([
            'channel_provider_id' => $providerChannel->id,
        ]);

        $retrievedChannel = $ChannelProviderField->channel;

        $this->assertInstanceOf(Channel::class, $retrievedChannel);
        $this->assertEquals($channel->id, $retrievedChannel->id);
    }
}
