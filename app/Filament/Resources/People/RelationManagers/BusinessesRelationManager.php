<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Models\Property;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessesRelationManager extends RelationManager
{
    protected static string $relationship = 'businesses';

    protected static ?string $title = 'المحال التجارية (السجلات)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('commercial_register_number')
                    ->label('رقم السجل التجاري')
                    ->required()
                    ->unique(table: 'businesses', column: 'commercial_register_number', ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('name')
                    ->label('اسم المحل')
                    ->required()
                    ->maxLength(255),
                Select::make('property_id')
                    ->label('العقار المرتبط')
                    ->placeholder('اختر العقار')
                    ->searchable()
                    ->preload()
                    ->options(fn (): array => Property::query()
                        ->orderBy('property_number')
                        ->pluck('property_number', 'id')
                        ->all()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('commercial_register_number')
                    ->label('رقم السجل')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('اسم المحل')
                    ->searchable(),
                TextColumn::make('property.property_number')
                    ->label('العقار')
                    ->placeholder('—'),
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make()
                    ->label('ربط سجل موجود'),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                ]),
            ]);
    }
}
