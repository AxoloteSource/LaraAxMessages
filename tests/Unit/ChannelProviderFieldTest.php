<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelProvider;
use App\Models\ChannelProviderField;
use App\Models\Field;
use App\Models\Provider;
use Tests\TestCase;

class ChannelProviderFieldTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_channel_provider_field(): void
    {
        $channelProviderField = ChannelProviderField::factory()->create();
        $this->assertDatabaseHas('channel_provider_fields', [
            'id' => $channelProviderField->id,
            'channel_provider_id' => $channelProviderField->channel_provider_id,
            'field_id' => $channelProviderField->field_id,
            'required' => $channelProviderField->required,
        ]);
    }

    public function test_it_belongs_to_a_channel_provider()
    {
        $channelProvider = ChannelProvider::factory()->create();

        $channelProviderField = ChannelProviderField::factory()->create(['channel_provider_id' => $channelProvider->id]);

        $this->assertInstanceOf(ChannelProvider::class, $channelProviderField->channelProvider);
        $this->assertEquals($channelProvider->id, $channelProviderField->channelProvider->id);
    }

    public function test_it_belongs_to_a_field()
    {
        $field = Field::factory()->create();

        $channelProviderField = ChannelProviderField::factory()->create(['field_id' => $field->id]);

        $this->assertInstanceOf(Field::class, $channelProviderField->field);
        $this->assertEquals($field->id, $channelProviderField->field->id);
    }

    public function test_it_can_retrieve_provider_through_channel_provider()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $channelProvider = ChannelProvider::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $channelProviderField = ChannelProviderField::factory()->create([
            'channel_provider_id' => $channelProvider->id,
        ]);

        $retrievedProvider = $channelProviderField->provider;

        $this->assertInstanceOf(Provider::class, $retrievedProvider);
        $this->assertEquals($provider->id, $retrievedProvider->id);
    }

    public function test_it_can_retrieve_channel_through_channel_provider()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $channelProvider = ChannelProvider::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $channelProviderField = ChannelProviderField::factory()->create([
            'channel_provider_id' => $channelProvider->id,
        ]);
        dd($channelProviderField->channel, $channelProvider->provider);

        $retrievedChannel = $channelProviderField->channel;

        $this->assertInstanceOf(Channel::class, $retrievedChannel);
        $this->assertEquals($channel->id, $retrievedChannel->id);
    }
}
