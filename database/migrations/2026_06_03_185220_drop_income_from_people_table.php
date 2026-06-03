<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('income');
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->decimal('income', 12, 2)->nullable()->after('phone');
        });
    }
};
