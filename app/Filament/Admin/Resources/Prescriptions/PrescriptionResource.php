<?php

namespace App\Filament\Admin\Resources\Prescriptions;

use App\Filament\Admin\Resources\Prescriptions\Widgets\CreatePrescriptionWidget;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Admin\Resources\Prescriptions\RelationManagers\MedicinesRelationManager;
use App\Filament\Admin\Resources\Prescriptions\Pages\ListPrescriptions;
use App\Filament\Admin\Resources\Prescriptions\Pages\CreatePrescription;
use App\Filament\Admin\Resources\Prescriptions\Pages\ViewPrescription;
use App\Filament\Admin\Resources\Prescriptions\Pages\EditPrescription;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use Carbon\Carbon;
use App\Filament\Admin\Resources\PrescriptionResource\Pages;
use App\Filament\Admin\Resources\PrescriptionResource\RelationManagers;
use App\Forms\Components\PatientForm;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?int $navigationSort = 5;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getWidgets(): array
    {
        return [
            CreatePrescriptionWidget::class,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->preload()
                    ->required()
                    ->createOptionForm([
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
                    ])
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname}")
                    ->columnSpanFull(),
                DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nb')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('patient_info')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->getStateUsing(fn($record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->searchable(['patient.firstname', 'patient.lastname']),
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
                Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(Prescription $record) => route('prescription-pdf', $record))
                    ->openUrlInNewTab(),
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
                        TextEntry::make('date')
                            ->label('Date')
                            ->date()
                            ->columnSpan(1),
                        TextEntry::make('purpose')
                            ->label('Purpose')
                            ->columnSpan(2),
                    ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
            MedicinesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrescriptions::route('/'),
            'create' => CreatePrescription::route('/create'),
            'view' => ViewPrescription::route('/{record}'),
            'edit' => EditPrescription::route('/{record}/edit'),
        ];
    }
}
