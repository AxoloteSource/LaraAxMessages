<?php

namespace Database\Seeders;

use App\Enums\Channel;
use App\Models\Field;
use App\Models\ProviderChannel;
use App\Models\ChannelProviderField;
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
                'subject' => true,
                'to' => true,
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
        $providerChannels = ProviderChannel::all();

        foreach ($providerChannels as $providerChannel) {
            foreach ($fieldNamesByChannel[$providerChannel->channel_id] as $key => $value) {
                $field = $fields->where('name', $key)->first();

                ChannelProviderField::updateOrCreate([
                    'channel_provider_id' => $providerChannel->id,
                    'field_id' => $field->id,
                    'required' => $value,
                ]);
            }
        }
    }
}
