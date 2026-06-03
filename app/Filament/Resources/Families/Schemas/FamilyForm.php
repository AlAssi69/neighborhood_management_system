<?php

namespace App\Filament\Resources\Families\Schemas;

use App\Models\Person;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات العائلة')
                    ->columns(2)
                    ->schema([
                        TextInput::make('family_card_number')
                            ->label('رقم بطاقة العائلة')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('head_person_id')
                            ->label('رب الأسرة')
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

                        TextInput::make('total_member_count')
                            ->label('عدد أفراد العائلة')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
            ]);
    }
}
