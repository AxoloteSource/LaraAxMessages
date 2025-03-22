<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\MessageDetails;
use App\Models\ChannelProviderField;
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
            'provider_channel_field_id' => $messageDetail->provider_channel_field_id,
            'message_id' => $messageDetail->message_id,
            'value' => $messageDetail->value,
        ]);
    }

    public function test_it_belongs_to_a_provider_channel_field()
    {
        $ChannelProviderField = ChannelProviderField::factory()->create();

        $messageDetails = MessageDetails::factory()->create(['provider_channel_field_id' => $ChannelProviderField->id]);

        $this->assertInstanceOf(ChannelProviderField::class, $messageDetails->ChannelProviderField);
        $this->assertEquals($ChannelProviderField->id, $messageDetails->ChannelProviderField->id);
    }

    public function test_it_belongs_to_a_message()
    {
        $message = Message::factory()->create();

        $messageDetails = MessageDetails::factory()->create(['message_id' => $message->id]);

        $this->assertInstanceOf(Message::class, $messageDetails->message);
        $this->assertEquals($message->id, $messageDetails->message->id);
    }
}
