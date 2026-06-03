<?php

namespace App\Filament\Resources\Properties\Tables;

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
            ->modifyQueryUsing(fn ($query) => $query->withResidentialAddress()->with('realEstateArea'))
            ->columns([
                TextColumn::make('property_number')
                    ->label('رقم العقار')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('realEstateArea.name')
                    ->label('المنطقة العقارية')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('full_residential_address')
                    ->label('عنوان السكن')
                    ->searchable(query: function ($query, string $search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('detailed_address', 'like', "%{$search}%")
                                ->orWhereHas('location', fn ($lq) => $lq->where('name', 'like', "%{$search}%"))
                                ->orWhereHas('building', fn ($bq) => $bq->where('building_number', 'like', "%{$search}%"))
                                ->orWhereHas('floor', fn ($fq) => $fq->where('label', 'like', "%{$search}%"));
                        });
                    })
                    ->wrap()
                    ->placeholder('—'),

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
                SelectFilter::make('real_estate_area_id')
                    ->label('المنطقة العقارية')
                    ->relationship('realEstateArea', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('location_id')
                    ->label('منطقة السكن')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),
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
