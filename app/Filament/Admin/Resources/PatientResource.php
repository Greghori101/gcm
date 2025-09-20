<?php

namespace App\Filament\Admin\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Admin\Resources\PatientResource\RelationManagers\PrescriptionsRelationManager;
use App\Filament\Admin\Resources\PatientResource\RelationManagers\CertificatesRelationManager;
use App\Filament\Admin\Resources\PatientResource\RelationManagers\TestRequestsRelationManager;
use App\Filament\Admin\Resources\PatientResource\Pages\ListPatients;
use App\Filament\Admin\Resources\PatientResource\Pages\CreatePatient;
use App\Filament\Admin\Resources\PatientResource\Pages\ViewPatient;
use App\Filament\Admin\Resources\PatientResource\Pages\EditPatient;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Filament\Admin\Resources\PatientResource\Pages;
use App\Filament\Admin\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Filament\Infolists;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?int $navigationSort = 3;

    protected static string | \BackedEnum | null $navigationIcon = 'hugeicons-patient';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()->columns(2)->schema([
                    TranslatableContainer::make(
                        TextInput::make('firstname')
                            ->maxLength(255)
                            ->required()
                    )
                        ->onlyMainLocaleRequired()
                        ->requiredLocales(['fr', 'ar']),
                    TranslatableContainer::make(
                        TextInput::make('lastname')
                            ->maxLength(255)
                            ->required()
                    )
                        ->onlyMainLocaleRequired()
                        ->requiredLocales(['fr', 'ar']),
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
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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


    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->columns(3) // Two columns
                    ->schema([
                        TextEntry::make('patient.firstname')
                            ->label('First Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        TextEntry::make('patient.lastname')
                            ->label('Last Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        TextEntry::make('patient.birthdate')
                            ->label('Birthdate')
                            ->inlineLabel(true)
                            ->date()
                            ->columnSpan(1),
                        TextEntry::make('patient.phone_number')
                            ->label('Phone Number')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        TextEntry::make('patient.blood_type')
                            ->inlineLabel(true)
                            ->label('Blood Type')
                            ->columnSpan(1),
                        TextEntry::make('patient.gender')
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
            PrescriptionsRelationManager::class,
            CertificatesRelationManager::class,
            TestRequestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view' => ViewPatient::route('/{record}'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }
}
