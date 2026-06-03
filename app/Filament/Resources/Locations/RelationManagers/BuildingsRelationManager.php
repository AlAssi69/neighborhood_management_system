<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BuildingsRelationManager extends RelationManager
{
    protected static string $relationship = 'buildings';

    protected static ?string $title = 'المباني';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('building_number')
                    ->label('رقم البناء')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('building_number')
            ->columns([
                TextColumn::make('building_number')
                    ->label('رقم البناء')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('floors_count')
                    ->label('عدد الطوابق')
                    ->counts('floors')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn ($record) => \App\Filament\Resources\Buildings\BuildingResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
