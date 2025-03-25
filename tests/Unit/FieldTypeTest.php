<?php

namespace Tests\Unit;

use App\Models\Field;
use App\Models\FieldTypes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class FieldTypeTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_it_has_many_fields()
    {
        $fieldType = FieldTypes::factory()->create();
        $fields = Field::factory()->count(3)->create(['field_type_id' => $fieldType->id]);

        $this->assertInstanceOf(HasMany::class, $fieldType->fields());
        $this->assertCount(3, $fieldType->fields);
        $this->assertTrue($fieldType->fields->contains($fields->first()));
    }
}
