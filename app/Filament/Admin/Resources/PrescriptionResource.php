<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getWidgets(): array
    {
        return [
            PrescriptionResource\Widgets\CreatePrescriptionWidget::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->preload()
                    ->required()
                    ->createOptionForm([
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
                    ])
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname}")
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nb')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_id')
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
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(Prescription $record) => route('prescription-pdf', $record))
                    ->openUrlInNewTab(),
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
                        Infolists\Components\TextEntry::make('date')
                            ->label('Date')
                            ->date()
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('purpose')
                            ->label('Purpose')
                            ->columnSpan(2),
                    ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\MedicinesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'view' => Pages\ViewPrescription::route('/{record}'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
        ];
    }
}
