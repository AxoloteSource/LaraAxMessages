<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderConfig>
 */
class ProviderConfigFactory extends Factory
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
            'name' => fake()->text(10),
            'active' => fake()->boolean,
            'config' => [
                'user' => fake()->email,
                'credentials' => bcrypt(fake()->text(10)),
            ],
        ];
    }
}
