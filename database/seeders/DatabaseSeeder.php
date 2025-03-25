<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FieldTypesSeeder::class,
            FieldSeeder::class,
            ChannelSeeder::class,
            ProviderSeeder::class,
            MessageStatusSeeder::class,
            ChannelProviderSeeder::class,
            ChannelProviderFieldSeeder::class,
            ProviderConfigSeeder::class,
        ]);
    }
}
