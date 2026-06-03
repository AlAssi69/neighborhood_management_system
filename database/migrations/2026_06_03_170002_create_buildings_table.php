<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnDelete();
            $table->string('building_number');
            $table->timestamps();

            $table->unique(['location_id', 'building_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
