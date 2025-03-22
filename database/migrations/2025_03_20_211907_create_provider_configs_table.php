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
        Schema::create('provider_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained();
            $table->string('name', 50);
            $table->boolean('active')->default(true);
            $table->jsonb('config')->nullable();
            $table->boolean('default')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_configs');
    }
};
