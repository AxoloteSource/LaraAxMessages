<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\MessageHistory;
use App\Models\MessageStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class MessageStatusTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_message_status(): void
    {
        $messageStatus = MessageStatus::factory()->create();
        $this->assertDatabaseHas('message_statuses', [
            'id' => $messageStatus->id,
            'name' => $messageStatus->name,
        ]);
    }

        public function test_it_has_many_messages()
        {
            $messageStatus = MessageStatus::factory()->create();
            $messages = Message::factory()->count(3)->create(['message_status_id' => $messageStatus->id]);
    
            $this->assertInstanceOf(HasMany::class, $messageStatus->messages());
            $this->assertCount(3, $messageStatus->messages);
            $this->assertTrue($messageStatus->messages->contains($messages->first()));
        }
    
        public function test_it_has_many_message_histories()
        {
            $messageStatus = MessageStatus::factory()->create();
            $messageHistories = MessageHistory::factory()->count(2)->create(['message_status_id' => $messageStatus->id]);
    
            $this->assertInstanceOf(HasMany::class, $messageStatus->messageHistories());
            $this->assertCount(2, $messageStatus->messageHistories);
            $this->assertTrue($messageStatus->messageHistories->contains($messageHistories->first()));
        }
}
