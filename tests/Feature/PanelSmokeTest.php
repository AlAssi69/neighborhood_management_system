<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\Family;
use App\Models\Location;
use App\Models\Person;
use App\Models\Property;
use App\Models\RealEstateArea;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@local.test',
            'password' => bcrypt('password'),
        ]);
    }

    private function seedMinimal(): void
    {
        $root = Location::create(['name' => 'الحي الأول']);
        $sub = Location::create(['name' => 'الحارة أ', 'parent_id' => $root->id]);
        $rea = RealEstateArea::create(['name' => 'منطقة 1']);
        $property = Property::create([
            'property_number' => 'P-1',
            'real_estate_area_id' => $rea->id,
            'location_id' => $sub->id,
        ]);
        $family = Family::create(['family_card_number' => 'F-1', 'total_member_count' => 3]);
        $person = Person::create([
            'national_id' => '123456',
            'first_name' => 'محمد',
            'last_name' => 'علي',
            'family_id' => $family->id,
            'income' => 1500,
        ]);
        $family->update(['head_person_id' => $person->id]);
        $person->properties()->attach($property->id, ['relation_type' => 'owner']);
        Business::create([
            'commercial_register_number' => 'C-1',
            'name' => 'بقالة',
            'property_id' => $property->id,
            'owner_person_id' => $person->id,
        ]);
    }

    public function test_resource_pages_render(): void
    {
        $this->actingAs($this->admin());
        $this->seedMinimal();

        foreach (['people', 'families', 'properties', 'businesses', 'locations', 'real-estate-areas', 'buildings'] as $slug) {
            $this->get("/admin/{$slug}")->assertSuccessful();
            $this->get("/admin/{$slug}/create")->assertSuccessful();
        }

        // Edit pages render their relation managers.
        $this->get('/admin/people/'.Person::first()->getKey().'/edit')->assertSuccessful();
        $this->get('/admin/families/'.Family::first()->getKey().'/edit')->assertSuccessful();
        $this->get('/admin/properties/'.Property::first()->getKey().'/edit')->assertSuccessful();

        $this->get('/admin')->assertSuccessful();
    }

    public function test_people_compound_filters(): void
    {
        $this->actingAs($this->admin());
        $this->seedMinimal();

        // The seeded person has income 1500 and a family of 3 members.
        Livewire::test(ListPeople::class)
            ->assertCanSeeTableRecords(Person::all())
            ->filterTable('income_bracket', ['income_from' => 2000, 'income_to' => 5000])
            ->assertCanNotSeeTableRecords(Person::all())
            ->resetTableFilters()
            ->filterTable('min_family_members', ['min_members' => 2])
            ->assertCanSeeTableRecords(Person::all())
            ->resetTableFilters()
            ->filterTable('min_family_members', ['min_members' => 10])
            ->assertCanNotSeeTableRecords(Person::all());
    }
}
