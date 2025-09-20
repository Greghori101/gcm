<?php

namespace App\Filament\Admin\Resources\Doctors;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Admin\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Admin\Resources\Doctors\Pages\ViewDoctor;
use App\Filament\Admin\Resources\Doctors\Pages\EditDoctor;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Filament\Admin\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?int $navigationSort = 2;

    protected static string | \BackedEnum | null $navigationIcon = 'hugeicons-doctor-01';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('logo')
                    ->avatar()
                    ->imageEditor()
                    ->collection('logo')
                    ->columnSpanFull(),
                TranslatableContainer::make(
                    TextInput::make('specialty')
                        ->maxLength(255)
                        ->required()
                )
                    ->onlyMainLocaleRequired()
                    ->requiredLocales(['fr', 'ar']),

                TextInput::make('national_order_number')
                    ->required()
                    ->maxLength(255),
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->options(function () {
                        return User::whereDoesntHave('doctor')->pluck('email', 'id');
                    })
                    ->createOptionForm([
                        Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('avatar')
                                    ->avatar()
                                    ->imageEditor()
                                    ->collection('avatar')
                                    ->columnSpanFull(),
                                TranslatableContainer::make(
                                    TextInput::make('firstname')
                                        ->maxLength(255)
                                        ->required()
                                )
                                    ->onlyMainLocaleRequired()
                                    ->requiredLocales(['fr', 'ar'])
                                    ->columnSpan(1),
                                TranslatableContainer::make(
                                    TextInput::make('lastname')
                                        ->maxLength(255)
                                        ->required()
                                )
                                    ->onlyMainLocaleRequired()
                                    ->requiredLocales(['fr', 'ar'])
                                    ->columnSpan(1),
                                DatePicker::make('birthdate')
                                    ->required()
                                    ->columnSpan(1),
                                TagsInput::make('phone_number')
                                    ->required()
                                    ->separator(',')
                                    ->columnSpan(1),
                                Select::make('blood_type')
                                    ->options(BloodTypes::toArray())
                                    ->required()
                                    ->columnSpan(1),
                                Select::make('gender')
                                    ->options(Genders::toArray())
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                DateTimePicker::make('email_verified_at')
                                    ->columnSpan(1),
                                TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ])
                    ])
                    ->createOptionAction(fn(Action $action) => $action->modalWidth('3xl'))
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor_info')
                    ->label('Doctor')
                    ->formatStateUsing(fn($state, $record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->getStateUsing(fn($record) => $record->user ? $record->user->firstname . ' ' . $record->user->lastname : '-')
                    ->searchable(['user.firstname', 'user.lastname']),
                TextColumn::make('specialty')
                    ->label('Specialty')
                    ->searchable(),
                TextColumn::make('national_order_number')
                    ->label('National Order #')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
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
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'view' => ViewDoctor::route('/{record}'),
            'edit' => EditDoctor::route('/{record}/edit'),
        ];
    }
}
