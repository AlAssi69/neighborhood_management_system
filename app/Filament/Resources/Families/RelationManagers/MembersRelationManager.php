<?php

namespace App\Filament\Resources\Families\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'أفراد العائلة';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('national_id')
                    ->label('الرقم الوطني')
                    ->required()
                    ->unique(table: 'people', column: 'national_id', ignoreRecord: true)
                    ->maxLength(20),
                TextInput::make('first_name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('الكنية')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('الهاتف')
                    ->tel()
                    ->maxLength(30),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('national_id')
            ->columns([
                TextColumn::make('national_id')
                    ->label('الرقم الوطني')
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label('الاسم الكامل'),
                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make()
                    ->label('ربط شخص موجود'),
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
