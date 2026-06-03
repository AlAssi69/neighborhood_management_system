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

    public function test_bundled_pdf_fonts_are_present(): void
    {
        $cairo = config('pdf.cairo');
        $qomra = config('pdf.qomra');

        $this->assertFileExists($cairo['dir'].'/'.$cairo['regular']);
        $this->assertFileExists($cairo['dir'].'/'.$cairo['bold']);
        $this->assertFileExists($qomra['dir'].'/'.$qomra['regular']);
        $this->assertFileExists($qomra['dir'].'/'.$qomra['bold']);
    }

    public function test_cairo_pdf_font_includes_digits_and_arabic_glyphs(): void
    {
        $cairoRegular = config('pdf.cairo.dir').'/'.config('pdf.cairo.regular');

        $this->assertFileExists($cairoRegular);

        // Merged cairo (arabic + latin subsets) is larger than arabic-only (~41 KiB).
        $this->assertGreaterThan(60_000, filesize($cairoRegular));
    }

    public function test_pdf_service_exposes_brand_font_families(): void
    {
        $data = app(PdfService::class)->pdfViewData();

        $this->assertSame('cairo', $data['pdfBodyFont']);
        $this->assertSame('qomra', $data['pdfHeadingFont']);
    }

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
        $this->assertSame('%PDF', substr($bytes, 0, 4));
        // mPDF embeds custom font subsets (internal names use MPDFAA+ prefix).
        $this->assertStringContainsString('Cairo', $bytes);
        $this->assertStringContainsString('Qomra', $bytes);
    }
}
