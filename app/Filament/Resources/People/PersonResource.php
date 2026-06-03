<?php

namespace App\Filament\Resources\People;

use App\Filament\Resources\People\Pages\CreatePerson;
use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Filament\Resources\People\Tables\PeopleTable;
use App\Models\Person;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'national_id';

    protected static string|\UnitEnum|null $navigationGroup = 'السكان';

    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return 'شخص';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الأشخاص';
    }

    public static function getNavigationLabel(): string
    {
        return 'الأشخاص';
    }

    public static function getGlobalSearchResultTitle(\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record->full_name.' — '.$record->national_id;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['national_id', 'first_name', 'father_name', 'last_name', 'phone'];
    }

    public static function form(Schema $schema): Schema
    {
        return PersonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeopleTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\People\RelationManagers\PropertiesRelationManager::class,
            \App\Filament\Resources\People\RelationManagers\BusinessesRelationManager::class,
            \App\Filament\Resources\People\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeople::route('/'),
            'create' => CreatePerson::route('/create'),
            'edit' => EditPerson::route('/{record}/edit'),
        ];
    }
}
