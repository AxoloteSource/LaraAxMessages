<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\ProviderChannel;
use Tests\TestCase;

class MessageTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_message(): void
    {
        $message = Message::factory()->create();
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'channel_provider_id' => $message->channel_provider_id,
            'created_user_id' => $message->created_user_id,
            'status_id' => $message->status_id,
            'attempts' => $message->attempts,
        ]);
    }

    public function test_it_belongs_to_a_provider_channel()
    {
        $providerChannel = ProviderChannel::factory()->create();

        $message = Message::factory()->create(['channel_provider_id' => $providerChannel->id]);

        $this->assertInstanceOf(ProviderChannel::class, $message->providerChannel);
        $this->assertEquals($providerChannel->id, $message->providerChannel->id);
    }

    public function test_it_belongs_to_a_status()
    {
        $messageStatus = MessageStatus::factory()->create();

        $message = Message::factory()->create(['status_id' => $messageStatus->id]);

        $this->assertInstanceOf(MessageStatus::class, $message->status);
        $this->assertEquals($messageStatus->id, $message->status->id);
    }

    public function test_it_can_retrieve_provider_through_channel_provider()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $channelProvider = ChannelProvider::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $message = Message::factory()->create([
            'channel_provider_id' => $channelProvider->id,
        ]);

        $retrievedProvider = $message->provider;

        $this->assertInstanceOf(Provider::class, $retrievedProvider);
        $this->assertEquals($provider->id, $retrievedProvider->id);
    }

    public function test_it_can_retrieve_channel_through_channel_provider()
    {
        $provider = Provider::factory()->create();

        $channel = Channel::factory()->create();

        $channelProvider = ProviderChannel::factory()->create([
            'provider_id' => $provider->id,
            'channel_id' => $channel->id,
        ]);

        $message = Message::factory()->create([
            'channel_provider_id' => $channelProvider->id,
        ]);

        $retrievedChannel = $message->channel;

        $this->assertInstanceOf(Channel::class, $retrievedChannel);
        $this->assertEquals($channel->id, $retrievedChannel->id);
    }
}
