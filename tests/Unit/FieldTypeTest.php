<?php

namespace Tests\Unit;

use App\Models\FieldTypes;
use Tests\TestCase;

class FieldTypeTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_field_types(): void
    {
        $fieldType = FieldTypes::factory()->create();
        $this->assertDatabaseHas('field_types', [
            'id' => $fieldType->id,
            'name' => $fieldType->name,
        ]);
    }
}
