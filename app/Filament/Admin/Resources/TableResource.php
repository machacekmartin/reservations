<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TableResource\Pages;
use App\Models\Table as TableModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TableResource extends Resource
{
    protected static ?string $model = TableModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('available')
                    ->required()
                    ->inline(false),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_reservation.user.name')
                    ->label('Occupied by')
                    ->default('-')
                    ->description(fn (TableModel $record, $state) => $state != '-' ? 'Until ' . $record->currentReservation?->end_at->format('H:i') : null),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Restaurant management';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['label'];
    }

    /**
     * @param  TableModel  $record
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->label;
    }

    /**
     * @param  TableModel  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Capacity' => (string) $record->capacity,
            'Occuiped' => $record->currentReservation ? 'Yes' : 'No',
        ];
    }
}
