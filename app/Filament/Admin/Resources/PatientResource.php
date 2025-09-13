<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Filament\Admin\Resources\PatientResource\Pages;
use App\Filament\Admin\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Filament\Infolists\Infolist;
use Filament\Infolists;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'hugeicons-patient';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->columns(2)->schema([
                    TranslatableContainer::make(
                        Forms\Components\TextInput::make('firstname')
                            ->maxLength(255)
                            ->required()
                    )
                        ->onlyMainLocaleRequired()
                        ->requiredLocales(['fr', 'ar']),
                    TranslatableContainer::make(
                        Forms\Components\TextInput::make('lastname')
                            ->maxLength(255)
                            ->required()
                    )
                        ->onlyMainLocaleRequired()
                        ->requiredLocales(['fr', 'ar']),
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
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
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


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()->columns(3) // Two columns
                    ->schema([
                        Infolists\Components\TextEntry::make('patient.firstname')
                            ->label('First Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.lastname')
                            ->label('Last Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.birthdate')
                            ->label('Birthdate')
                            ->inlineLabel(true)
                            ->date()
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.phone_number')
                            ->label('Phone Number')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.blood_type')
                            ->inlineLabel(true)
                            ->label('Blood Type')
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.gender')
                            ->inlineLabel(true)
                            ->label('Gender')
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\PrescriptionsRelationManager::class,
            RelationManagers\CertificatesRelationManager::class,
            RelationManagers\TestRequestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
