<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('channel_provider_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_provider_id')->constrained();
            $table->foreignId('field_id')->constrained();
            $table->boolean('required')->default(false);
            $table->timestamps();

            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_provider_fields');
    }
};
