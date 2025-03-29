<?php

namespace Database\Seeders;

use App\Enums\Channel;
use App\Models\ChannelProvider;
use App\Models\ChannelProviderField;
use App\Models\Field;
use Illuminate\Database\Seeder;

class ChannelProviderFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $whatsappChannelId = Channel::WHATSAPP->value;
        $emailChannelId = Channel::EMAIL->value;

        $fieldNamesByChannel = [
            $whatsappChannelId => [
                'template_name' => true,
                'phone_number' => true,
                'params' => false,
            ],
            $emailChannelId => [
                'template_name' => true,
                'subject' => true,
                'to' => true,
                'cc' => false,
                'params' => false,
            ],
        ];

        $fields = Field::all();
        $channelProviders = ChannelProvider::all();

        foreach ($channelProviders as $channelProvider) {
            foreach ($fieldNamesByChannel[$channelProvider->channel_id] as $key => $value) {
                $field = $fields->where('name', $key)->first();

                ChannelProviderField::updateOrCreate([
                    'channel_provider_id' => $channelProvider->id,
                    'field_id' => $field->id,
                    'required' => $value,
                ]);
            }
        }
    }
}
