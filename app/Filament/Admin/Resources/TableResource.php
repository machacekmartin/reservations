<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TableResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers\ReservationsRelationManager;
use App\Models\Table as TableModel;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
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
                Section::make()
                    ->columns(6)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('label')
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('capacity')
                            ->required()
                            ->numeric(),
                        Toggle::make('available')
                            ->label('Available')
                            ->inline(false),
                    ]),
                Section::make()
                    ->columns(4)
                    ->schema([
                        TextInput::make('dimensions.width')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                        TextInput::make('dimensions.height')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                        TextInput::make('dimensions.x')
                            ->numeric()
                            ->minValue(20)
                            ->rules('required')
                            ->required(),
                        TextInput::make('dimensions.y')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->poll('2s')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_reservation.user.name')
                    ->label('Occupied by')
                    ->default('-')
                    ->description(fn (TableModel $record, $state) => $state != '-' ? 'Until ' . $record->currentReservation?->end_at->format('H:i') : null),
                TextColumn::make('size')
                    ->label('Size')
                    ->getStateUsing(fn (TableModel $record) => $record->dimensions->width . 'x' . $record->dimensions->height),

                TextColumn::make('location')
                    ->label('Location')
                    ->getStateUsing(fn (TableModel $record) => $record->dimensions->x . 'x' . $record->dimensions->y),

                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('available')
                    ->label('Available to see')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            ReservationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTables::route('/'),
            'edit' => Pages\EditTable::route('/records/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manual management';
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
