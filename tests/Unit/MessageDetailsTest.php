<?php

namespace Tests\Unit;

use App\Models\ChannelProviderField;
use App\Models\Message;
use App\Models\MessageDetails;
use Tests\TestCase;

class MessageDetailsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_message_details(): void
    {
        $messageDetail = MessageDetails::factory()->create();
        $this->assertDatabaseHas('message_details', [
            'id' => $messageDetail->id,
            'channel_provider_field_id' => $messageDetail->channel_provider_field_id,
            'message_id' => $messageDetail->message_id,
            'value' => $messageDetail->value,
        ]);
    }

    public function test_it_belongs_to_a_channel_provider_field()
    {
        $channelProviderField = ChannelProviderField::factory()->create();

        $messageDetails = MessageDetails::factory()->create(['channel_provider_field_id' => $channelProviderField->id]);

        $this->assertInstanceOf(ChannelProviderField::class, $messageDetails->channelProviderField);
        $this->assertEquals($channelProviderField->id, $messageDetails->channelProviderField->id);
    }

    public function test_it_belongs_to_a_message()
    {
        $message = Message::factory()->create();

        $messageDetails = MessageDetails::factory()->create(['message_id' => $message->id]);

        $this->assertInstanceOf(Message::class, $messageDetails->message);
        $this->assertEquals($message->id, $messageDetails->message->id);
    }
}
