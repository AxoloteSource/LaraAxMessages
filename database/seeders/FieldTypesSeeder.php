<?php

namespace Database\Seeders;

use App\Models\FieldTypes;
use Illuminate\Database\Seeder;

class FieldTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldTypes::upsert([
            [
                'id' => 1,
                'name' => 'Texto',
            ],
            [
                'id' => 2,
                'name' => 'Numerico',
            ],
        ], ['id'], ['name']);
    }
}
