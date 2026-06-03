<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_number')->unique();
            $table->string('real_estate_area')->nullable();
            $table->unsignedInteger('floor_number')->nullable();
            $table->text('detailed_address')->nullable();
            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations')
                ->nullOnDelete();
            $table->timestamps();

            $table->index('real_estate_area');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
