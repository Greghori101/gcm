<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NurseResource\Pages;
use App\Filament\Admin\Resources\NurseResource\RelationManagers;
use App\Models\Nurse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NurseResource extends Resource
{
    protected static ?string $model = Nurse::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'uni-user-nurse-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->options(function () {
                        return \App\Models\User::whereDoesntHave('nurse')->pluck('email', 'id');
                    })
                    ->createOptionForm([
                        Forms\Components\TextInput::make('firstname')
                            ->label('First Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('lastname')
                            ->label('Last Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\DatePicker::make('birthdate')
                            ->label('Birthdate')
                            ->required(),
                        Forms\Components\TagsInput::make('phone_number')
                            ->label('Phone Number')
                            ->required()
                            ->separator(','),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
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
                Tables\Columns\TextColumn::make('nurse_info')
                    ->label('Nurse')
                    ->formatStateUsing(fn($state, $record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->getStateUsing(fn($record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->searchable(['user.firstname', 'user.lastname']),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListNurses::route('/'),
            'create' => Pages\CreateNurse::route('/create'),
            'view' => Pages\ViewNurse::route('/{record}'),
            'edit' => Pages\EditNurse::route('/{record}/edit'),
        ];
    }
}
