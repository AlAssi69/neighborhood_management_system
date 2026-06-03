<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم المنطقة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label('المنطقة الأعلى')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('properties_count')
                    ->label('عدد العقارات')
                    ->counts('properties')
                    ->badge(),

                TextColumn::make('children_count')
                    ->label('عدد المناطق الفرعية')
                    ->counts('children')
                    ->badge(),
            ])
            ->defaultSort('name')
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
