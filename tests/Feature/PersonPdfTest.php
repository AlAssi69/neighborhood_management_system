<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Location;
use App\Models\Person;
use App\Models\Property;
use App\Services\PdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_person_official_form_renders_to_pdf(): void
    {
        $location = Location::create(['name' => 'الحي الأول']);
        $property = Property::create([
            'property_number' => 'P-7',
            'real_estate_area' => 'منطقة 2',
            'floor_number' => 3,
            'location_id' => $location->id,
        ]);
        $family = Family::create(['family_card_number' => 'F-9', 'total_member_count' => 4]);
        $person = Person::create([
            'national_id' => '5566778',
            'first_name' => 'خالد',
            'father_name' => 'أحمد',
            'last_name' => 'العلي',
            'phone' => '0590000000',
            'income' => 2500,
            'family_id' => $family->id,
        ]);
        $person->properties()->attach($property->id, ['relation_type' => 'owner']);

        $person->loadMissing(['family.head', 'properties.location', 'businesses']);

        $bytes = app(PdfService::class)->renderView('pdf.person-form', [
            'person' => $person,
            'neighborhoodName' => 'حي الاختبار',
            'issuedAt' => '2026-06-03',
        ]);

        $this->assertNotEmpty($bytes);
        // Valid PDFs start with the "%PDF" magic header.
        $this->assertSame('%PDF', substr($bytes, 0, 4));
    }
}
