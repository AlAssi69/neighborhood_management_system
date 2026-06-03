<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained('people')
                ->cascadeOnDelete();
            $table->string('document_type')->nullable();
            $table->string('title')->nullable();
            $table->string('file_path');
            $table->timestamps();

            $table->index('document_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_documents');
    }
};
