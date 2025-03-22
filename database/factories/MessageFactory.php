<?php

namespace Database\Factories;

use App\Models\MessageStatus;
use App\Models\ProviderChannel;
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
            'provider_channel_id' => ProviderChannel::factory(),
            'created_user_id' => fake()->randomNumber,
            'status_id' => MessageStatus::factory(),
            'attempts' => fake()->randomNumber,
        ];
    }
}
