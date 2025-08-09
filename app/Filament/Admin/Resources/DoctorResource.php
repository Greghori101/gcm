<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Filament\Admin\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Actions\Action as FormsAction;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'hugeicons-doctor-01';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('logo')
                    ->avatar()
                    ->imageEditor()
                    ->collection('logo')
                    ->columnSpanFull(),
                TranslatableContainer::make(
                    Forms\Components\TextInput::make('specialty')
                        ->maxLength(255)
                        ->required()
                )
                    ->onlyMainLocaleRequired()
                    ->requiredLocales(['fr', 'ar']),

                Forms\Components\TextInput::make('national_order_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->options(function () {
                        return \App\Models\User::whereDoesntHave('doctor')->pluck('email', 'id');
                    })
                    ->createOptionForm([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('avatar')
                                    ->avatar()
                                    ->imageEditor()
                                    ->collection('avatar')
                                    ->columnSpanFull(),
                                TranslatableContainer::make(
                                    Forms\Components\TextInput::make('firstname')
                                        ->maxLength(255)
                                        ->required()
                                )
                                    ->onlyMainLocaleRequired()
                                    ->requiredLocales(['fr', 'ar'])
                                    ->columnSpan(1),
                                TranslatableContainer::make(
                                    Forms\Components\TextInput::make('lastname')
                                        ->maxLength(255)
                                        ->required()
                                )
                                    ->onlyMainLocaleRequired()
                                    ->requiredLocales(['fr', 'ar'])
                                    ->columnSpan(1),
                                Forms\Components\DatePicker::make('birthdate')
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\TagsInput::make('phone_number')
                                    ->required()
                                    ->separator(',')
                                    ->columnSpan(1),
                                Forms\Components\Select::make('blood_type')
                                    ->options(BloodTypes::toArray())
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\Select::make('gender')
                                    ->options(Genders::toArray())
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ])
                    ])
                    ->createOptionAction(fn(FormsAction $action) => $action->modalWidth('3xl'))
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specialty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
