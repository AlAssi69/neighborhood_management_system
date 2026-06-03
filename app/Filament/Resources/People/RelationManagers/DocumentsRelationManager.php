<?php

namespace App\Filament\Resources\People\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'المستندات المؤرشفة';

    /**
     * @var array<string, string>
     */
    public const DOCUMENT_TYPES = [
        'national_id' => 'بطاقة شخصية',
        'family_card' => 'بطاقة عائلية',
        'property_deed' => 'سند ملكية',
        'commercial_register' => 'سجل تجاري',
        'other' => 'أخرى',
    ];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('عنوان المستند')
                    ->required()
                    ->maxLength(255),
                Select::make('document_type')
                    ->label('نوع المستند')
                    ->options(self::DOCUMENT_TYPES)
                    ->default('other'),
                FileUpload::make('file_path')
                    ->label('الملف (صورة أو PDF)')
                    ->disk('documents')
                    ->directory(fn () => 'person-'.$this->getOwnerRecord()->getKey())
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(10240)
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),
                TextColumn::make('document_type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => self::DOCUMENT_TYPES[$state] ?? (string) $state),
                TextColumn::make('created_at')
                    ->label('تاريخ الرفع')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('رفع مستند'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('تنزيل')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn ($record) => Storage::disk('documents')->download($record->file_path))
                    ->visible(fn ($record): bool => $record->file_path
                        && Storage::disk('documents')->exists($record->file_path)),
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
