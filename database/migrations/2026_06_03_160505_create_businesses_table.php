<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('commercial_register_number')->unique();
            $table->string('name');
            $table->foreignId('property_id')
                ->nullable()
                ->constrained('properties')
                ->nullOnDelete();
            $table->foreignId('owner_person_id')
                ->nullable()
                ->constrained('people')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
