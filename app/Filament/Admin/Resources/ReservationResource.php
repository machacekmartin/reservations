<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ReservationStatus;
use App\Filament\Admin\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('General information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('guest_count')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('note')
                            ->maxLength(100),
                        Forms\Components\Select::make('status')
                            ->options(ReservationStatus::class)
                            ->required(),
                    ]),
                Forms\Components\Fieldset::make('Time details')
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('start_at')
                            ->required()
                            ->seconds(false)
                            ->before('end_at'),
                        Forms\Components\DateTimePicker::make('end_at')
                            ->required()
                            ->seconds(false)
                            ->after('start_at'),
                        Forms\Components\DateTimePicker::make('remind_at')
                            ->seconds(false),
                        Forms\Components\DateTimePicker::make('arrived_at')
                            ->seconds(false),
                        Forms\Components\DateTimePicker::make('canceled_at')
                            ->seconds(false),
                    ])->columns(3),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->description(fn (Reservation $record) => $record->user->email)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('tables.label')
                    ->getStateUsing(fn (Reservation $record) => $record->tables->pluck('label')->join(', '))
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remind_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('arrived_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('canceled_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
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

    public static function getWidgets(): array
    {
        return [
            //
        ];
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Restaurant management';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'user.email'];
    }

    /**
     * @param  Reservation  $record
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return 'Starts at ' . $record->start_at->format('Y-m-d H:i');
    }

    /**
     * @param  Reservation  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'User' => $record->user->name,
            'Note' => $record->note ?? '-',
        ];
    }

    /**
     * Limit the global search only to reservations starting between yesterday and tomorrow
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()
            ->where('start_at', '>=', now()->yesterday()->startOfDay())
            ->where('start_at', '<=', now()->tomorrow()->endOfDay());
    }
}
