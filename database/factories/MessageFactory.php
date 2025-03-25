<?php

namespace Database\Factories;

use App\Models\ChannelProvider;
use App\Models\MessageStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageSettings>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'channel_provider_id' => ChannelProvider::factory(),
            'created_user_id' => fake()->randomNumber,
            'message_status_id' => MessageStatus::factory(),
            'attempts' => fake()->numberBetween(0, 255),
        ];
    }
}
