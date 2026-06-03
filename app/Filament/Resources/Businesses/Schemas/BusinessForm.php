<?php

namespace App\Filament\Resources\Businesses\Schemas;

use App\Models\Person;
use App\Models\Property;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المحل التجاري')
                    ->columns(2)
                    ->schema([
                        TextInput::make('commercial_register_number')
                            ->label('رقم السجل التجاري')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('name')
                            ->label('اسم المحل')
                            ->required()
                            ->maxLength(255),

                        Select::make('owner_person_id')
                            ->label('المالك / صاحب السجل')
                            ->placeholder('اختر الشخص')
                            ->searchable()
                            ->preload()
                            ->options(fn (): array => Person::query()
                                ->orderBy('last_name')
                                ->get()
                                ->mapWithKeys(fn (Person $person) => [
                                    $person->id => $person->full_name.' ('.$person->national_id.')',
                                ])
                                ->all()),

                        Select::make('property_id')
                            ->label('العقار المرتبط')
                            ->placeholder('اختر العقار')
                            ->searchable()
                            ->preload()
                            ->options(fn (): array => Property::query()
                                ->orderBy('property_number')
                                ->pluck('property_number', 'id')
                                ->all()),
                    ]),
            ]);
    }
}
