<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\MessageHistory;
use App\Models\MessageStatus;
use Tests\TestCase;

class MessageHistoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_message_history(): void
    {
        $messageHistory = MessageHistory::factory()->create();
        $this->assertDatabaseHas('message_histories', [
            'id' => $messageHistory->id,
            'message_id' => $messageHistory->message_id,
            'message_status_id' => $messageHistory->message_status_id,
        ]);
    }

    public function test_it_belongs_to_a_status()
    {
        $messageStatus = MessageStatus::factory()->create();

        $messageHistory = MessageHistory::factory()->create(['message_status_id' => $messageStatus->id]);

        $this->assertInstanceOf(MessageStatus::class, $messageHistory->messageStatus);
        $this->assertEquals($messageStatus->id, $messageHistory->messageStatus->id);
    }

    public function test_it_belongs_to_a_message()
    {
        $message = Message::factory()->create();

        $messageHistory = MessageHistory::factory()->create(['message_id' => $message->id]);

        $this->assertInstanceOf(Message::class, $messageHistory->message);
        $this->assertEquals($message->id, $messageHistory->message->id);
    }
}
