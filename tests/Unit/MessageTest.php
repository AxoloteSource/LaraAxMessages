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
            'provider_channel_id' => $message->provider_channel_id,
            'created_user_id' => $message->created_user_id,
            'status_id' => $message->status_id,
            'attempts' => $message->attempts,
        ]);
    }

    public function test_it_belongs_to_a_provider_channel()
    {
        $providerChannel = ProviderChannel::factory()->create();

        $message = Message::factory()->create(['provider_channel_id' => $providerChannel->id]);

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
}
