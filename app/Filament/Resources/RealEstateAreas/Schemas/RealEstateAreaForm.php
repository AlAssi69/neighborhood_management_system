<?php

namespace App\Filament\Resources\RealEstateAreas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RealEstateAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم المنطقة العقارية')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }
}
