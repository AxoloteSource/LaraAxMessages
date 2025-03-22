<?php

namespace Tests\Unit;

use App\Models\Field;
use App\Models\ProviderChannel;
use App\Models\ChannelProviderField;
use Tests\TestCase;

class ChannelProviderFieldTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_provider_channel_field(): void
    {
        $ChannelProviderField = ChannelProviderField::factory()->create();
        $this->assertDatabaseHas('provider_channel_fields', [
            'id' => $ChannelProviderField->id,
            'channel_provider_id' => $ChannelProviderField->channel_provider_id,
            'field_id' => $ChannelProviderField->field_id,
            'required' => $ChannelProviderField->required,
        ]);
    }

    public function test_it_belongs_to_a_provider_channel()
    {
        $providerChannel = ProviderChannel::factory()->create();

        $ChannelProviderField = ChannelProviderField::factory()->create(['channel_provider_id' => $providerChannel->id]);

        $this->assertInstanceOf(ProviderChannel::class, $ChannelProviderField->providerChannel);
        $this->assertEquals($providerChannel->id, $ChannelProviderField->providerChannel->id);
    }

    public function test_it_belongs_to_a_field()
    {
        $field = Field::factory()->create();

        $ChannelProviderField = ChannelProviderField::factory()->create(['field_id' => $field->id]);

        $this->assertInstanceOf(Field::class, $ChannelProviderField->field);
        $this->assertEquals($field->id, $ChannelProviderField->field->id);
    }
}
