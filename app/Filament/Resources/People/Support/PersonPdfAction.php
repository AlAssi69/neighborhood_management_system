<?php

namespace App\Filament\Resources\People\Support;

use App\Models\Person;
use App\Services\PdfService;
use Filament\Actions\Action;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Reusable "export official form as PDF" action for a Person record.
 * Used both as a table row action and an edit-page header action.
 */
class PersonPdfAction
{
    public static function make(string $name = 'exportPdf'): Action
    {
        return Action::make($name)
            ->label('نموذج رسمي (PDF)')
            ->icon('heroicon-o-document-arrow-down')
            ->color('gray')
            ->action(fn (Person $record): StreamedResponse => static::stream($record));
    }

    protected static function stream(Person $person): StreamedResponse
    {
        $person->loadMissing(['family.head', 'properties.location', 'businesses']);

        $pdf = app(PdfService::class)->renderView('pdf.person-form', [
            'person' => $person,
            'neighborhoodName' => config('app.name'),
            'issuedAt' => now()->format('Y-m-d'),
        ]);

        return response()->streamDownload(
            fn () => print($pdf),
            'person-'.$person->national_id.'.pdf',
            ['Content-Type' => 'application/pdf'],
        );
    }
}
