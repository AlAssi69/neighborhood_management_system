<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Location;
use App\Models\RealEstateArea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات العقار')
                    ->columns(2)
                    ->schema([
                        Select::make('real_estate_area_id')
                            ->label('المنطقة العقارية')
                            ->searchable()
                            ->preload()
                            ->options(fn (): array => RealEstateArea::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('اسم المنطقة العقارية')
                                    ->required()
                                    ->unique(table: 'real_estate_areas', column: 'name'),
                            ])
                            ->createOptionUsing(fn (array $data) => RealEstateArea::create($data)->getKey()),

                        TextInput::make('property_number')
                            ->label('رقم العقار')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ]),

                Section::make('عنوان السكن')
                    ->columns(2)
                    ->schema([
                        Select::make('location_id')
                            ->label('منطقة السكن')
                            ->placeholder('اختر منطقة السكن')
                            ->searchable()
                            ->options(fn (): array => Location::optionsWithFullPath())
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('building_id', null);
                                $set('floor_id', null);
                            }),

                        Select::make('building_id')
                            ->label('رقم البناء')
                            ->placeholder('اختر رقم البناء')
                            ->searchable()
                            ->options(fn (Get $get): array => static::buildingOptions($get('location_id') ? (int) $get('location_id') : null))
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('floor_id', null)),

                        Select::make('floor_id')
                            ->label('الطابق')
                            ->placeholder('اختر الطابق')
                            ->searchable()
                            ->live()
                            ->options(fn (Get $get): array => static::floorOptions($get('building_id') ? (int) $get('building_id') : null)),

                        Textarea::make('detailed_address')
                            ->label('عنوان تفصيلي')
                            ->rows(2)
                            ->live(onBlur: true)
                            ->columnSpanFull(),

                        TextInput::make('full_residential_address')
                            ->label('العنوان الكامل')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn ($state, Get $get, ?\App\Models\Property $record): string => static::previewAddress($get, $record))
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function previewAddress(Get $get, ?\App\Models\Property $record): string
    {
        $parts = [];

        if ($get('location_id')) {
            $location = Location::find($get('location_id'));
            if ($location) {
                $parts[] = $location->full_path;
            }
        }

        if ($get('building_id')) {
            $building = Building::find($get('building_id'));
            if ($building) {
                $parts[] = $building->building_number;
            }
        }

        if ($get('floor_id')) {
            $floor = Floor::find($get('floor_id'));
            if ($floor) {
                $parts[] = $floor->label;
            }
        }

        if (filled($get('detailed_address'))) {
            $parts[] = $get('detailed_address');
        }

        if ($parts !== []) {
            return implode(', ', $parts);
        }

        return $record?->full_residential_address ?? '—';
    }

    /**
     * @return array<int, string>
     */
    protected static function buildingOptions(?int $locationId): array
    {
        if (! $locationId) {
            return [];
        }

        return Building::query()
            ->where('location_id', $locationId)
            ->orderBy('building_number')
            ->pluck('building_number', 'id')
            ->all();
    }

    /**
     * @return array<int, string>
     */
    protected static function floorOptions(?int $buildingId): array
    {
        if (! $buildingId) {
            return [];
        }

        return Floor::query()
            ->where('building_id', $buildingId)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->pluck('label', 'id')
            ->all();
    }

}
