<?php

namespace Tests\Unit;

use App\Models\Field;
use App\Models\FieldTypes;
use Tests\TestCase;

class FieldTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_field(): void
    {
        $field = Field::factory()->create();
        $this->assertDatabaseHas('fields', [
            'id' => $field->id,
            'name' => $field->name,
            'field_type_id' => $field->field_type_id,
        ]);
    }

    public function test_it_has_one_provider()
    {
        $fieldType = FieldTypes::factory()->create();

        $field = Field::factory()->create(['field_type_id' => $fieldType->id]);

        $this->assertInstanceOf(FieldTypes::class, $field->fieldType);
        $this->assertEquals($fieldType->id, $field->fieldType->id);
    }
}
