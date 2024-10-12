<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Channel::insert([
            ['name' => 'email', 'description' => 'Email Channel', 'active' => true],
            ['name' => 'whatsapp', 'description' => 'WhatsApp Channel', 'active' => false],
            ['name' => 'sms', 'description' => 'SMS Channel', 'active' => false],
            ['name' => 'phone', 'description' => 'Phone Channel', 'active' => false],
            ['name' => 'push', 'description' => 'Push Notification Channel', 'active' => false],
            ['name' => 'slack', 'description' => 'Slack Channel', 'active' => false],
            ['name' => 'telegram', 'description' => 'Telegram Channel', 'active' => false],
        ]);
    }
}
