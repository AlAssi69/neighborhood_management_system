<?php

namespace App\Filament\Resources\Businesses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('commercial_register_number')
                    ->label('رقم السجل التجاري')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('name')
                    ->label('اسم المحل')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('owner.full_name')
                    ->label('المالك')
                    ->placeholder('—'),

                TextColumn::make('property.property_number')
                    ->label('العقار')
                    ->placeholder('—')
                    ->searchable(),
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
