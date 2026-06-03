<?php

namespace App\Filament\Resources\Buildings;

use App\Filament\Resources\Buildings\Pages\CreateBuilding;
use App\Filament\Resources\Buildings\Pages\EditBuilding;
use App\Filament\Resources\Buildings\Pages\ListBuildings;
use App\Filament\Resources\Buildings\RelationManagers\FloorsRelationManager;
use App\Filament\Resources\Buildings\Schemas\BuildingForm;
use App\Filament\Resources\Buildings\Tables\BuildingsTable;
use App\Models\Building;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $recordTitleAttribute = 'building_number';

    protected static string|\UnitEnum|null $navigationGroup = 'الإعدادات والبيانات المرجعية';

    protected static ?int $navigationSort = 92;

    public static function getModelLabel(): string
    {
        return 'مبنى';
    }

    public static function getPluralModelLabel(): string
    {
        return 'المباني';
    }

    public static function getNavigationLabel(): string
    {
        return 'المباني';
    }

    public static function form(Schema $schema): Schema
    {
        return BuildingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BuildingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FloorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBuildings::route('/'),
            'create' => CreateBuilding::route('/create'),
            'edit' => EditBuilding::route('/{record}/edit'),
        ];
    }
}
