<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Models\Property;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property_number')
                    ->label('رقم العقار')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('real_estate_area')
                    ->label('المنطقة العقارية')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->label('الموقع')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('floor_number')
                    ->label('الطابق')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('residents_count')
                    ->label('عدد الساكنين')
                    ->counts('residents')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('businesses_count')
                    ->label('عدد المحال')
                    ->counts('businesses')
                    ->badge()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->label('الموقع')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('real_estate_area')
                    ->label('المنطقة العقارية')
                    ->options(fn (): array => Property::query()
                        ->whereNotNull('real_estate_area')
                        ->distinct()
                        ->orderBy('real_estate_area')
                        ->pluck('real_estate_area', 'real_estate_area')
                        ->all()),
            ])
            ->defaultSort('property_number')
            ->recordActions([
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
