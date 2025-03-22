<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderChannel>
 */
class ProviderChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::factory(),
            'channel_id' => Channel::factory(),
            'active' => fake()->boolean,
        ];
    }
}
