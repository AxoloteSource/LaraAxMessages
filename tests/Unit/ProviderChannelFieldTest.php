<?php

namespace Tests\Unit;

use App\Models\Field;
use App\Models\ProviderChannel;
use App\Models\ProviderChannelField;
use Tests\TestCase;

class ProviderChannelFieldTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider_channel_field(): void
    {
        $providerChannelField = ProviderChannelField::factory()->create();
        $this->assertDatabaseHas('provider_channel_fields', [
            'id' => $providerChannelField->id,
            'provider_channel_id' => $providerChannelField->provider_channel_id,
            'field_id' => $providerChannelField->field_id,
            'required' => $providerChannelField->required,
        ]);
    }

    public function test_it_belongs_to_a_provider_channel()
    {
        $providerChannel = ProviderChannel::factory()->create();

        $providerChannelField = ProviderChannelField::factory()->create(['provider_channel_id' => $providerChannel->id]);

        $this->assertInstanceOf(ProviderChannel::class, $providerChannelField->providerChannel);
        $this->assertEquals($providerChannel->id, $providerChannelField->providerChannel->id);
    }

    public function test_it_belongs_to_a_field()
    {
        $field = Field::factory()->create();

        $providerChannelField = ProviderChannelField::factory()->create(['field_id' => $field->id]);

        $this->assertInstanceOf(Field::class, $providerChannelField->field);
        $this->assertEquals($field->id, $providerChannelField->field->id);
    }
}
