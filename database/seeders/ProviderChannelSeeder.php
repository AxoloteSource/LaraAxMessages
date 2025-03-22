<?php

namespace Database\Seeders;

use App\Enums\Channel;
use App\Enums\Provider;
use App\Models\ProviderChannel;
use Illuminate\Database\Seeder;

class ProviderChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProviderChannel::upsert([
            [
                'id' => 1,
                'provider_id' => Provider::META,
                'channel_id' => Channel::WHATSAPP,
            ],
            [
                'id' => 2,
                'provider_id' => Provider::SENDGRID,
                'channel_id' => Channel::EMAIL,
            ],
            [
                'id' => 3,
                'provider_id' => Provider::MAILGUN,
                'channel_id' => Channel::EMAIL,
            ],
        ], ['id'], ['provider_id', 'channel_id']);
    }
}
