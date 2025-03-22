<?php

namespace Tests\Unit;

use App\Models\MessageStatus;
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
}
