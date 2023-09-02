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
            ->defaultGroup('restaurant.name')
            ->paginationPageOptions([25, 50, 100])
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_reservation')
                    ->label('Occupied by')
                    ->formatStateUsing(fn ($state) => $state?->user->name)
                    ->description(fn ($state) => $state?->user->email),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('restaurant')
                    ->relationship('restaurant', 'name')
                    ->placeholder('All restaurants'),
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
            'Occuiped' => $record->isOccupied() ? 'Yes' : 'No',
        ];
    }
}
