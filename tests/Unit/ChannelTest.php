<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelProvider;
use App\Models\Provider;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function test_create_channel()
    {
        $channel = Channel::factory()->create();
        $this->assertDatabaseHas('channels', [
            'id' => $channel->id,
            'description' => $channel->description,
            'active' => $channel->active,
        ]);
    }

    public function test_it_has_many_providers()
    {
        $channel = Channel::factory()->create();

        $providers[] = Provider::factory()->create();
        $providers[] = Provider::factory()->create();

        $channel->providers()->attach([$providers[0]->id, $providers[1]->id]);

        $this->assertCount(count($providers), $channel->providers);
        $this->assertTrue($channel->providers->contains($providers[0]));
        $this->assertTrue($channel->providers->contains($providers[1]));
    }

    public function test_it_has_many_channel_provider()
    {
        $channel = Channel::factory()->create();

        $channelProviders[] = ChannelProvider::factory()->create(['channel_id' => $channel->id]);
        $channelProviders[] = ChannelProvider::factory()->create(['channel_id' => $channel->id]);

        $this->assertCount(count($channelProviders), $channel->channelProvider);
        $this->assertTrue($channel->channelProvider->contains($channelProviders[0]));
        $this->assertTrue($channel->channelProvider->contains($channelProviders[1]));
    }
}
