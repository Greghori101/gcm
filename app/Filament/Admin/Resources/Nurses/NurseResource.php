<?php

namespace App\Filament\Admin\Resources\Nurses;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Nurses\Pages\ListNurses;
use App\Filament\Admin\Resources\Nurses\Pages\CreateNurse;
use App\Filament\Admin\Resources\Nurses\Pages\ViewNurse;
use App\Filament\Admin\Resources\Nurses\Pages\EditNurse;
use App\Filament\Admin\Resources\NurseResource\Pages;
use App\Filament\Admin\Resources\NurseResource\RelationManagers;
use App\Models\Nurse;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NurseResource extends Resource
{
    protected static ?string $model = Nurse::class;

    protected static ?int $navigationSort = 9;

    protected static string | \BackedEnum | null $navigationIcon = 'uni-user-nurse-o';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->options(function () {
                        return User::whereDoesntHave('nurse')->pluck('email', 'id');
                    })
                    ->createOptionForm([
                        TextInput::make('firstname')
                            ->label('First Name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('lastname')
                            ->label('Last Name')
                            ->maxLength(255)
                            ->required(),
                        DatePicker::make('birthdate')
                            ->label('Birthdate')
                            ->required(),
                        TagsInput::make('phone_number')
                            ->label('Phone Number')
                            ->required()
                            ->separator(','),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nurse_info')
                    ->label('Nurse')
                    ->formatStateUsing(fn($state, $record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->getStateUsing(fn($record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->searchable(['user.firstname', 'user.lastname']),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListNurses::route('/'),
            'create' => CreateNurse::route('/create'),
            'view' => ViewNurse::route('/{record}'),
            'edit' => EditNurse::route('/{record}/edit'),
        ];
    }
}
