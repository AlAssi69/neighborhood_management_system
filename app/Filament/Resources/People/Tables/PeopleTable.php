<?php

namespace App\Filament\Resources\People\Tables;

use App\Filament\Resources\People\Support\PersonPdfAction;
use App\Models\Location;
use App\Models\Property;
use App\Models\RealEstateArea;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('properties'))
            ->columns([
                TextColumn::make('national_id')
                    ->label('الرقم الوطني')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('first_name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('father_name')
                    ->label('اسم الأب')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('last_name')
                    ->label('الكنية')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),

                TextColumn::make('property_numbers')
                    ->label('أرقام العقارات')
                    ->state(fn ($record): string => $record->properties
                        ->pluck('property_number')
                        ->filter()
                        ->unique()
                        ->implode('، '))
                    ->placeholder('—')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas(
                            'properties',
                            fn (Builder $q) => $q->where('property_number', 'like', '%'.$search.'%'),
                        );
                    })
                    ->toggleable(),

                TextColumn::make('family.family_card_number')
                    ->label('بطاقة العائلة')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('properties_count')
                    ->label('العقارات')
                    ->counts('properties')
                    ->badge()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('family_id')
                    ->label('العائلة')
                    ->relationship('family', 'family_card_number')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('area')
                    ->label('المنطقة الجغرافية')
                    ->options(fn (): array => Location::query()
                        ->whereNull('parent_id')
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        $ids = Location::subtreeIds((int) $data['value']);

                        return $query->whereHas('properties', fn (Builder $q) => $q->whereIn('location_id', $ids));
                    }),

                SelectFilter::make('real_estate_area')
                    ->label('المنطقة العقارية')
                    ->options(fn (): array => RealEstateArea::query()
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas(
                            'properties',
                            fn (Builder $q) => $q->where('real_estate_area_id', $data['value']),
                        );
                    }),

                Filter::make('property_number')
                    ->label('رقم العقار')
                    ->schema([
                        TextInput::make('property_number')
                            ->label('رقم العقار'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['property_number'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('properties', fn (Builder $q) => $q->where('property_number', 'like', '%'.$data['property_number'].'%'));
                    })
                    ->indicateUsing(fn (array $data): ?string => filled($data['property_number'] ?? null)
                        ? 'رقم العقار: '.$data['property_number']
                        : null),

                Filter::make('min_family_members')
                    ->label('حجم العائلة')
                    ->schema([
                        TextInput::make('min_members')
                            ->label('عدد الأفراد على الأقل')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['min_members'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('family', fn (Builder $q) => $q->where('total_member_count', '>=', $data['min_members']));
                    })
                    ->indicateUsing(fn (array $data): ?string => filled($data['min_members'] ?? null)
                        ? 'عائلة لا تقل عن '.$data['min_members'].' أفراد'
                        : null),
            ])
            ->recordActions([
                PersonPdfAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
