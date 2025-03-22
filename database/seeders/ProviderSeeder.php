<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::upsert([
            [
                'id' => 1,
                'name' => 'Meta',
            ],
            [
                'id' => 2,
                'name' => 'SendGrid',
            ],
            [
                'id' => 3,
                'name' => 'Mailgun',
            ],
        ], ['id'], ['name']);
    }
}
