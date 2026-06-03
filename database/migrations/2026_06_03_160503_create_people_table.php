<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('national_id')->unique();
            $table->string('first_name');
            $table->string('father_name')->nullable();
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->decimal('income', 12, 2)->nullable();
            $table->foreignId('family_id')
                ->nullable()
                ->constrained('families')
                ->nullOnDelete();
            $table->timestamps();

            $table->index('last_name');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
