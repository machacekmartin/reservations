<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers\ReservationsRelationManager;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar')
                    ->avatar(),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->minLength(4)
                        ->alphaNum()
                        ->maxLength(50),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique('users', 'email')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->minLength(8)
                        ->prefixIcon('heroicon-o-lock-closed')
                        ->hiddenOn('edit')
                        ->autocomplete(false)
                        ->required(),

                    PhoneInput::make('phone'),

                    Forms\Components\DateTimePicker::make('email_verified_at'),

                    Forms\Components\Select::make('roles')
                        ->multiple()
                        ->minItems(1)
                        ->preload()
                        ->relationship('roles', 'name'),
                ])->columnSpan(4),
            ])->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->defaultImageUrl(fn (User $record) => Filament::getUserAvatarUrl($record))
                    ->circular()
                    ->extraCellAttributes(['class' => 'w-10']),

                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->description(fn (User $record) => $record->roles->pluck('name')->join(', ')),

                Tables\Columns\TextColumn::make('email')
                    ->url(fn (string $state) => "mailto:{$state}")
                    ->icon('heroicon-o-envelope')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->url(fn (string $state) => "tel:{$state}")
                    ->icon('heroicon-o-phone')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reservations')
                    ->label('# of ' . 'Reservations')
                    ->getStateUsing(fn (User $record) => $record->reservations()->count())
                    ->extraCellAttributes(['class' => 'w-full']),
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
            ReservationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manual management';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    /**
     * @param  User  $record
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    /**
     * @param  User  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
        ];
    }
}
