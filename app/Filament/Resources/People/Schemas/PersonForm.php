<?php

namespace App\Filament\Resources\People\Schemas;

use App\Models\Family;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المعلومات الشخصية')
                    ->columns(2)
                    ->schema([
                        TextInput::make('national_id')
                            ->label('الرقم الوطني')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->rule('regex:/^[0-9]{5,20}$/')
                            ->validationMessages([
                                'unique' => 'هذا الرقم الوطني مُسجّل مسبقاً لشخص آخر.',
                                'regex' => 'الرقم الوطني يجب أن يتكوّن من أرقام فقط (من 5 إلى 20 خانة).',
                            ])
                            ->maxLength(20),

                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(30),

                        TextInput::make('first_name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('father_name')
                            ->label('اسم الأب')
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->label('الكنية')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('income')
                            ->label('الدخل')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('₪'),
                    ]),

                Section::make('الانتماء العائلي')
                    ->schema([
                        Select::make('family_id')
                            ->label('العائلة (رقم بطاقة العائلة)')
                            ->placeholder('بدون عائلة')
                            ->searchable()
                            ->preload()
                            ->options(fn (): array => Family::query()
                                ->orderBy('family_card_number')
                                ->pluck('family_card_number', 'id')
                                ->all())
                            ->createOptionForm([
                                TextInput::make('family_card_number')
                                    ->label('رقم بطاقة العائلة')
                                    ->required()
                                    ->unique(table: 'families', column: 'family_card_number'),
                            ])
                            ->createOptionUsing(fn (array $data) => Family::create($data)->getKey()),
                    ]),
            ]);
    }
}
