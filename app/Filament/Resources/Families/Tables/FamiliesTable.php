<?php

namespace App\Filament\Resources\Families\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FamiliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('family_card_number')
                    ->label('رقم بطاقة العائلة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('head.full_name')
                    ->label('رب الأسرة')
                    ->placeholder('—'),

                TextColumn::make('total_member_count')
                    ->label('عدد الأفراد (مُعلن)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('members_count')
                    ->label('عدد الأفراد (مُسجل)')
                    ->counts('members')
                    ->badge(),
            ])
            ->filters([
                Filter::make('min_members')
                    ->label('حجم العائلة')
                    ->schema([
                        TextInput::make('min_members')
                            ->label('عدد الأفراد على الأقل')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['min_members'] ?? null)) {
                            return $query;
                        }

                        return $query->where('total_member_count', '>=', $data['min_members']);
                    })
                    ->indicateUsing(fn (array $data): ?string => filled($data['min_members'] ?? null)
                        ? 'لا تقل عن '.$data['min_members'].' أفراد'
                        : null),
            ])
            ->defaultSort('family_card_number')
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
