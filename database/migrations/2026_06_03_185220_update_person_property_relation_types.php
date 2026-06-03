<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('person_property')
            ->where('relation_type', 'resident')
            ->update(['relation_type' => 'tenant']);

        Schema::table('person_property', function (Blueprint $table) {
            $table->string('relation_type')->default('tenant')->change();
        });
    }

    public function down(): void
    {
        DB::table('person_property')
            ->where('relation_type', 'tenant')
            ->update(['relation_type' => 'resident']);

        DB::table('person_property')
            ->where('relation_type', 'vacant')
            ->update(['relation_type' => 'resident']);

        Schema::table('person_property', function (Blueprint $table) {
            $table->string('relation_type')->default('resident')->change();
        });
    }
};
