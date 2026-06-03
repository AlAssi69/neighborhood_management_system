<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->foreignId('head_person_id')
                ->nullable()
                ->after('family_card_number')
                ->constrained('people')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropConstrainedForeignId('head_person_id');
        });
    }
};
