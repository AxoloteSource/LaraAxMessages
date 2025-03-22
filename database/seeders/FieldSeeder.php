<?php

namespace Database\Seeders;

use App\Enums\FieldType;
use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::upsert([
            [
                'id' => 1,
                'name' => 'template_name',
                'field_type_id' => FieldType::TEXT,
            ],
            [
                'id' => 2,
                'name' => 'subject',
                'field_type_id' => FieldType::TEXT,
            ],
            [
                'id' => 3,
                'name' => 'to',
                'field_type_id' => FieldType::TEXT,
            ],
            [
                'id' => 4,
                'name' => 'cc',
                'field_type_id' => FieldType::TEXT,
            ],
            [
                'id' => 5,
                'name' => 'phone_number',
                'field_type_id' => FieldType::TEXT,
            ],
            [
                'id' => 6,
                'name' => 'params',
                'field_type_id' => FieldType::TEXT,
            ],
        ], ['id'], ['name', 'field_type_id']);
    }
}
