<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageHistory>
 */
class MessageHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message_id' => Message::factory(),
            'status_id' => MessageStatus::factory(),
        ];
    }
}
