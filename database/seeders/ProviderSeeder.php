<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::insert([
            ['provider_type_id' => 1, 'name' => 'sendgrid', 'active' => true, 'config' => json_encode([])],
            ['provider_type_id' => 2, 'name' => 'meta', 'active' => false, 'config' => json_encode([])],
            ['provider_type_id' => 3, 'name' => 'slack', 'active' => false]
        ]);
    }
}
