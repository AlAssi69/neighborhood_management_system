<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained('people')
                ->cascadeOnDelete();
            $table->foreignId('property_id')
                ->constrained('properties')
                ->cascadeOnDelete();
            // resident | owner
            $table->string('relation_type')->default('resident');
            $table->timestamps();

            $table->unique(['person_id', 'property_id', 'relation_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_property');
    }
};
