<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\ChannelProviderField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageDetails>
 */
class MessageDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_channel_field_id' => ChannelProviderField::factory(),
            'message_id' => Message::factory(),
            'value' => fake()->sentence,
        ];
    }
}
