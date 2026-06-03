<?php

namespace App\Filament\Resources\RealEstateAreas;

use App\Filament\Resources\RealEstateAreas\Pages\CreateRealEstateArea;
use App\Filament\Resources\RealEstateAreas\Pages\EditRealEstateArea;
use App\Filament\Resources\RealEstateAreas\Pages\ListRealEstateAreas;
use App\Filament\Resources\RealEstateAreas\Schemas\RealEstateAreaForm;
use App\Filament\Resources\RealEstateAreas\Tables\RealEstateAreasTable;
use App\Models\RealEstateArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RealEstateAreaResource extends Resource
{
    protected static ?string $model = RealEstateArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'الإعدادات والبيانات المرجعية';

    protected static ?int $navigationSort = 91;

    public static function getModelLabel(): string
    {
        return 'منطقة عقارية';
    }

    public static function getPluralModelLabel(): string
    {
        return 'المناطق العقارية';
    }

    public static function getNavigationLabel(): string
    {
        return 'المناطق العقارية';
    }

    public static function form(Schema $schema): Schema
    {
        return RealEstateAreaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RealEstateAreasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRealEstateAreas::route('/'),
            'create' => CreateRealEstateArea::route('/create'),
            'edit' => EditRealEstateArea::route('/{record}/edit'),
        ];
    }
}
