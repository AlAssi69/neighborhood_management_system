<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Resources\People\PersonResource;
use App\Filament\Resources\People\Support\PersonPdfAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerson extends EditRecord
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PersonPdfAction::make(),
            DeleteAction::make(),
        ];
    }
}
