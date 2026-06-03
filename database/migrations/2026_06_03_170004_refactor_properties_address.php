<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('real_estate_area_id')
                ->nullable()
                ->after('property_number')
                ->constrained('real_estate_areas')
                ->nullOnDelete();

            $table->foreignId('building_id')
                ->nullable()
                ->after('location_id')
                ->constrained('buildings')
                ->nullOnDelete();

            $table->foreignId('floor_id')
                ->nullable()
                ->after('building_id')
                ->constrained('floors')
                ->nullOnDelete();
        });

        $this->migrateLegacyData();

        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['real_estate_area']);
            $table->dropColumn(['real_estate_area', 'floor_number']);
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->index('real_estate_area_id');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('real_estate_area')->nullable()->after('property_number');
            $table->unsignedInteger('floor_number')->nullable()->after('real_estate_area');
        });

        $properties = DB::table('properties')->get();

        foreach ($properties as $property) {
            $reaName = null;
            $floorNumber = null;

            if ($property->real_estate_area_id) {
                $reaName = DB::table('real_estate_areas')
                    ->where('id', $property->real_estate_area_id)
                    ->value('name');
            }

            if ($property->floor_id) {
                $floorNumber = DB::table('floors')
                    ->where('id', $property->floor_id)
                    ->value('label');
            }

            DB::table('properties')
                ->where('id', $property->id)
                ->update([
                    'real_estate_area' => $reaName,
                    'floor_number' => is_numeric($floorNumber) ? (int) $floorNumber : null,
                ]);
        }

        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['real_estate_area_id']);
            $table->dropForeign(['building_id']);
            $table->dropForeign(['floor_id']);
            $table->dropIndex(['real_estate_area_id']);
            $table->dropColumn(['real_estate_area_id', 'building_id', 'floor_id']);
            $table->index('real_estate_area');
        });
    }

    protected function migrateLegacyData(): void
    {
        if (! Schema::hasColumn('properties', 'real_estate_area')) {
            return;
        }

        $areaNames = DB::table('properties')
            ->whereNotNull('real_estate_area')
            ->where('real_estate_area', '!=', '')
            ->distinct()
            ->pluck('real_estate_area');

        $areaIdsByName = [];

        foreach ($areaNames as $name) {
            $id = DB::table('real_estate_areas')->insertGetId([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $areaIdsByName[$name] = $id;
        }

        $buildingCache = [];

        foreach (DB::table('properties')->get() as $property) {
            $updates = [];

            if ($property->real_estate_area && isset($areaIdsByName[$property->real_estate_area])) {
                $updates['real_estate_area_id'] = $areaIdsByName[$property->real_estate_area];
            }

            if ($property->location_id && $property->floor_number !== null) {
                $cacheKey = $property->location_id.'|1';

                if (! isset($buildingCache[$cacheKey])) {
                    $existingBuildingId = DB::table('buildings')
                        ->where('location_id', $property->location_id)
                        ->where('building_number', '1')
                        ->value('id');

                    if ($existingBuildingId) {
                        $buildingCache[$cacheKey] = $existingBuildingId;
                    } else {
                        $buildingCache[$cacheKey] = DB::table('buildings')->insertGetId([
                            'location_id' => $property->location_id,
                            'building_number' => '1',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                $buildingId = $buildingCache[$cacheKey];
                $floorLabel = (string) $property->floor_number;

                $floorId = DB::table('floors')
                    ->where('building_id', $buildingId)
                    ->where('label', $floorLabel)
                    ->value('id');

                if (! $floorId) {
                    $floorId = DB::table('floors')->insertGetId([
                        'building_id' => $buildingId,
                        'label' => $floorLabel,
                        'sort_order' => (int) $property->floor_number,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $updates['building_id'] = $buildingId;
                $updates['floor_id'] = $floorId;
            }

            if ($updates !== []) {
                DB::table('properties')
                    ->where('id', $property->id)
                    ->update($updates);
            }
        }
    }
};
