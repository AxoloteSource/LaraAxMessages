<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Channel::upsert([
            [
                'id' => 1,
                'name' => 'WhatsApp',
                'description' => 'Envío de mensaje a través de WhatsApp',
            ],
            [
                'id' => 2,
                'name' => 'Email',
                'description' => 'Envío de correo electrónico',
            ],
        ], ['id'], ['name', 'description']);
    }
}
