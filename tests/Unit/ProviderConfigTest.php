<?php

namespace Tests\Unit;

use App\Models\ProviderConfig;
use Tests\TestCase;

class ProviderConfigTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider_config(): void
    {
        $providerConfig = ProviderConfig::factory()->create();
        $this->assertDatabaseHas('provider_configs', [
            'id' => $providerConfig->id,
            'provider_id' => $providerConfig->provider_id,
            'name' => $providerConfig->name,
            'active' => $providerConfig->active,
            'config' => json_encode($providerConfig->config),
        ]);
    }
}
