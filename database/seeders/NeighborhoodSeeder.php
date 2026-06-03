<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Family;
use App\Models\Location;
use App\Models\Person;
use App\Models\Property;
use Illuminate\Database\Seeder;

class NeighborhoodSeeder extends Seeder
{
    public function run(): void
    {
        // Hierarchical areas: main area -> sub areas -> blocks.
        $areas = [
            'الحي الشرقي' => [
                'حارة الزيتون' => ['مربع 1', 'مربع 2'],
                'حارة النخيل' => ['مربع 3'],
            ],
            'الحي الغربي' => [
                'حارة الياسمين' => ['مربع 4', 'مربع 5'],
            ],
        ];

        $leafLocations = [];

        foreach ($areas as $mainName => $subAreas) {
            $main = Location::create(['name' => $mainName]);

            foreach ($subAreas as $subName => $blocks) {
                $sub = Location::create(['name' => $subName, 'parent_id' => $main->id]);

                foreach ($blocks as $blockName) {
                    $leafLocations[] = Location::create(['name' => $blockName, 'parent_id' => $sub->id]);
                }
            }
        }

        $realEstateAreas = ['المنطقة العقارية أ', 'المنطقة العقارية ب', 'المنطقة العقارية ج'];

        // Create properties spread across the leaf locations.
        $properties = [];
        for ($i = 1; $i <= 12; $i++) {
            $location = $leafLocations[($i - 1) % count($leafLocations)];

            $properties[] = Property::create([
                'property_number' => 'P-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'real_estate_area' => $realEstateAreas[($i - 1) % count($realEstateAreas)],
                'floor_number' => ($i % 4) + 1,
                'detailed_address' => 'عنوان تفصيلي رقم '.$i,
                'location_id' => $location->id,
            ]);
        }

        $firstNames = ['محمد', 'أحمد', 'علي', 'خالد', 'سامي', 'فاطمة', 'مريم', 'سارة', 'هدى', 'ليلى'];
        $lastNames = ['العلي', 'الحسن', 'الخطيب', 'النجار', 'الشامي', 'الحلبي', 'القاسم'];

        $personIndex = 0;

        // Create families, each with a head and a few members.
        for ($f = 1; $f <= 6; $f++) {
            $family = Family::create([
                'family_card_number' => 'FC-'.str_pad((string) $f, 4, '0', STR_PAD_LEFT),
                'total_member_count' => 0,
            ]);

            $memberCount = 3 + ($f % 4); // between 3 and 6
            $members = [];

            for ($m = 0; $m < $memberCount; $m++) {
                $personIndex++;

                $person = Person::create([
                    'national_id' => (string) (100000000 + $personIndex),
                    'first_name' => $firstNames[$personIndex % count($firstNames)],
                    'father_name' => $firstNames[($personIndex + 3) % count($firstNames)],
                    'last_name' => $lastNames[$f % count($lastNames)],
                    'phone' => '059'.str_pad((string) ($personIndex * 137 % 10000000), 7, '0', STR_PAD_LEFT),
                    'income' => 800 + (($personIndex * 173) % 4200),
                    'family_id' => $family->id,
                ]);

                $members[] = $person;

                // Link each person to a property as resident (head is owner).
                $property = $properties[($personIndex - 1) % count($properties)];
                $person->properties()->attach($property->id, [
                    'relation_type' => $m === 0 ? 'owner' : 'resident',
                ]);
            }

            $family->update([
                'head_person_id' => $members[0]->id,
                'total_member_count' => $memberCount,
            ]);

            // Give the family head a business in their property.
            if ($f % 2 === 0) {
                Business::create([
                    'commercial_register_number' => 'CR-'.str_pad((string) $f, 4, '0', STR_PAD_LEFT),
                    'name' => 'محل '.$members[0]->first_name,
                    'property_id' => $properties[($f - 1) % count($properties)]->id,
                    'owner_person_id' => $members[0]->id,
                ]);
            }
        }
    }
}
