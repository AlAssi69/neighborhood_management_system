<?php

namespace App\Filament\Resources\Buildings\Schemas;

use App\Models\Location;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BuildingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('location_id')
                    ->label('منطقة السكن')
                    ->required()
                    ->searchable()
                    ->options(fn (): array => Location::optionsWithFullPath()),

                TextInput::make('building_number')
                    ->label('رقم البناء')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
