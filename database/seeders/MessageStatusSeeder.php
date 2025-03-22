<?php

namespace Database\Seeders;

use App\Models\MessageStatus;
use Illuminate\Database\Seeder;

class MessageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MessageStatus::upsert([
            [
                'id' => 1,
                'name' => 'Procesando',
            ],
            [
                'id' => 2,
                'name' => 'Enviado',
            ],
            [
                'id' => 3,
                'name' => 'Entregado',
            ],
            [
                'id' => 4,
                'name' => 'No entregado',
            ],
        ], ['id'], ['name']);
    }
}
