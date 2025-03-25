<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelProvider;
use App\Models\Provider;
use Tests\TestCase;

class ProviderTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider(): void
    {
        $provider = Provider::factory()->create();
        $this->assertDatabaseHas('providers', [
            'id' => $provider->id,
            'name' => $provider->name,
        ]);
    }

    public function test_it_has_many_channels()
    {
        $provider = Provider::factory()->create();

        $channels[] = Channel::factory()->create();
        $channels[] = Channel::factory()->create();

        $provider->channels()->attach([$channels[0]->id, $channels[1]->id]);

        $this->assertCount(count($channels), $provider->channels);
        $this->assertTrue($provider->channels->contains($channels[0]));
        $this->assertTrue($provider->channels->contains($channels[1]));
    }

    public function test_it_has_many_channel_provider()
    {
        $provider = Provider::factory()->create();

        $channelProviders[] = ChannelProvider::factory()->create(['provider_id' => $provider->id]);
        $channelProviders[] = ChannelProvider::factory()->create(['provider_id' => $provider->id]);

        $this->assertCount(count($channelProviders), $provider->channelProvider);
        $this->assertTrue($provider->channelProvider->contains($channelProviders[0]));
        $this->assertTrue($provider->channelProvider->contains($channelProviders[1]));
    }
}
