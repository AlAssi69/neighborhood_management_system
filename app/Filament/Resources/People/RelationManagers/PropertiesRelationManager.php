<?php

namespace App\Filament\Resources\People\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    protected static ?string $title = 'العقارات (سكن / ملكية)';

    /**
     * @var array<string, string>
     */
    protected static array $relationTypes = [
        'resident' => 'ساكن',
        'owner' => 'مالك',
    ];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('relation_type')
                    ->label('نوع العلاقة')
                    ->options(static::$relationTypes)
                    ->default('resident')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->withResidentialAddress()->with('realEstateArea'))
            ->recordTitleAttribute('property_number')
            ->columns([
                TextColumn::make('property_number')
                    ->label('رقم العقار')
                    ->searchable(),
                TextColumn::make('realEstateArea.name')
                    ->label('المنطقة العقارية')
                    ->placeholder('—'),
                TextColumn::make('full_residential_address')
                    ->label('عنوان السكن')
                    ->wrap()
                    ->placeholder('—'),
                TextColumn::make('pivot.relation_type')
                    ->label('نوع العلاقة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => static::$relationTypes[$state] ?? (string) $state),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('ربط عقار')
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect()->label('العقار'),
                        Select::make('relation_type')
                            ->label('نوع العلاقة')
                            ->options(static::$relationTypes)
                            ->default('resident')
                            ->required(),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
