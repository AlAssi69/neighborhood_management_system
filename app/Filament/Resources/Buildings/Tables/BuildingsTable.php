<?php

namespace App\Filament\Resources\Buildings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BuildingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location.full_path')
                    ->label('منطقة السكن')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('building_number')
                    ->label('رقم البناء')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('floors_count')
                    ->label('عدد الطوابق')
                    ->counts('floors')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->label('منطقة السكن')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('building_number')
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
