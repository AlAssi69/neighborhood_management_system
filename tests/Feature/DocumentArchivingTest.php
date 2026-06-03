<?php

namespace Tests\Feature;

use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\RelationManagers\DocumentsRelationManager;
use App\Models\ArchivedDocument;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DocumentArchivingTest extends TestCase
{
    use RefreshDatabase;

    public function test_document_upload_stores_path_not_blob(): void
    {
        Storage::fake('documents');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@local.test',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($admin);

        $person = Person::create([
            'national_id' => '999888',
            'first_name' => 'سارة',
            'last_name' => 'حسن',
        ]);

        $file = UploadedFile::fake()->create('id-card.pdf', 120, 'application/pdf');

        Livewire::test(DocumentsRelationManager::class, [
            'ownerRecord' => $person,
            'pageClass' => EditPerson::class,
        ])
            ->callTableAction('create', data: [
                'title' => 'بطاقة شخصية',
                'document_type' => 'national_id',
                'file_path' => [$file],
            ])
            ->assertHasNoTableActionErrors();

        $document = ArchivedDocument::query()->firstOrFail();

        $this->assertSame($person->id, $document->person_id);
        $this->assertSame('national_id', $document->document_type);
        $this->assertNotEmpty($document->file_path);
        Storage::disk('documents')->assertExists($document->file_path);
    }
}
