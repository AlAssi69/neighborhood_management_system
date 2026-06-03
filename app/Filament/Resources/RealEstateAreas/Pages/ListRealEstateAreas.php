<?php

namespace App\Filament\Resources\RealEstateAreas\Pages;

use App\Filament\Resources\RealEstateAreas\RealEstateAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealEstateAreas extends ListRecords
{
    protected static string $resource = RealEstateAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
