<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Models\Location;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                Section::make('بيانات العقار')
                    ->columns(2)
                    ->schema([
                        TextInput::make('property_number')
                            ->label('رقم العقار')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('real_estate_area')
                            ->label('المنطقة العقارية')
                            ->maxLength(255),

                        TextInput::make('floor_number')
                            ->label('رقم الطابق')
                            ->numeric()
                            ->minValue(0),

                        Textarea::make('detailed_address')
                            ->label('العنوان التفصيلي')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('الموقع ضمن الحي')
                    ->columns(2)
                    ->schema([
                        // Cascading address: choosing a main area populates the
                        // sub-area options. Not persisted; only used to filter.
                        Select::make('main_location_id')
                            ->label('المنطقة الرئيسية')
                            ->placeholder('اختر المنطقة الرئيسية')
                            ->options(fn (): array => Location::query()
                                ->whereNull('parent_id')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Set $set, ?string $state, Get $get): void {
                                $locationId = $get('location_id');

                                if ($locationId && ! $state) {
                                    $set('main_location_id', static::rootAncestorId((int) $locationId));
                                }
                            })
                            ->afterStateUpdated(fn (Set $set) => $set('location_id', null)),

                        Select::make('location_id')
                            ->label('المنطقة الفرعية / الموقع التفصيلي')
                            ->placeholder('اختر الموقع')
                            ->searchable()
                            ->options(fn (Get $get): array => static::subtreeOptions(
                                $get('main_location_id') ? (int) $get('main_location_id') : null,
                            )),
                    ]),
            ]);
    }

    /**
     * The main-area (root) ancestor id of a given location.
     */
    protected static function rootAncestorId(int $locationId): ?int
    {
        $location = Location::find($locationId);

        while ($location && $location->parent_id) {
            $location = $location->parent;
        }

        return $location?->id;
    }

    /**
     * The selected main area plus all of its descendants, keyed for a select.
     *
     * @return array<int, string>
     */
    protected static function subtreeOptions(?int $rootId): array
    {
        if (! $rootId) {
            return [];
        }

        $all = Location::query()->get(['id', 'name', 'parent_id']);
        $byParent = $all->groupBy('parent_id');

        $options = [];
        $walk = function (int $id, string $prefix) use (&$walk, $byParent, $all, &$options): void {
            $node = $all->firstWhere('id', $id);

            if (! $node) {
                return;
            }

            $label = $prefix === '' ? $node->name : $prefix.' / '.$node->name;
            $options[$id] = $label;

            foreach ($byParent->get($id, collect()) as $child) {
                $walk($child->id, $label);
            }
        };

        $walk($rootId, '');

        return $options;
    }
}
