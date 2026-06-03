<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Models\Location;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم المنطقة')
                    ->required()
                    ->maxLength(255),

                Select::make('parent_id')
                    ->label('المنطقة الأعلى (الأب)')
                    ->placeholder('بدون - منطقة رئيسية')
                    ->searchable()
                    ->preload()
                    ->options(fn (?Location $record): array => Location::query()
                        ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))
                        ->get()
                        ->mapWithKeys(fn (Location $location) => [$location->id => $location->full_path])
                        ->all()),
            ]);
    }
}
