<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelProvider;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\Provider;
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
            'message_status_id' => $message->message_status_id,
            'attempts' => $message->attempts,
        ]);
    }

    public function test_it_belongs_to_a_channel_provider()
    {
        $channelProvider = ChannelProvider::factory()->create();

        $message = Message::factory()->create(['channel_provider_id' => $channelProvider->id]);

        $this->assertInstanceOf(ChannelProvider::class, $message->channelProvider);
        $this->assertEquals($channelProvider->id, $message->channelProvider->id);
    }

    public function test_it_belongs_to_a_status()
    {
        $messageStatus = MessageStatus::factory()->create();

        $message = Message::factory()->create(['message_status_id' => $messageStatus->id]);

        $this->assertInstanceOf(MessageStatus::class, $message->messageStatus);
        $this->assertEquals($messageStatus->id, $message->messageStatus->id);
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

        $channelProvider = ChannelProvider::factory()->create([
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
