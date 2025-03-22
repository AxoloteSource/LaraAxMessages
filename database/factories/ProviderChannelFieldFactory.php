<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\ProviderChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderChannelField>
 */
class ProviderChannelFieldFactory extends Factory
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
            'field_id' => Field::factory(),
            'required' => fake()->boolean,
        ];
    }
}
