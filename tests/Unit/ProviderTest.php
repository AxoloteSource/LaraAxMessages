<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Provider;
use App\Models\ProviderChannel;
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

    public function test_it_has_many_provider_channels()
    {
        $provider = Provider::factory()->create();

        $providerChannels[] = ProviderChannel::factory()->create(['provider_id' => $provider->id]);
        $providerChannels[] = ProviderChannel::factory()->create(['provider_id' => $provider->id]);

        $this->assertCount(count($providerChannels), $provider->providerChannel);
        $this->assertTrue($provider->providerChannel->contains($providerChannels[0]));
        $this->assertTrue($provider->providerChannel->contains($providerChannels[1]));
    }
}
