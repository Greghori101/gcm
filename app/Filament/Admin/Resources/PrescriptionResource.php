<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('patient')
                        ->schema([
                            PatientForm::make('patient')
                                ->columnSpan('full'),
                            Forms\Components\DatePicker::make('date')
                                ->default(Carbon::today())
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('purpose')
                                ->required()
                                ->columnSpanFull(),

                        ]),
                    Forms\Components\Wizard\Step::make('medicines')
                        ->schema([
                            Forms\Components\Repeater::make('prescriptionMedicines')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('medicine_id')
                                        ->relationship('medicine', 'name')
                                        ->required()
                                        ->searchable(['name', 'brand', 'dosage'])

                                        ->getSearchResultsUsing(function (string $search) {
                                            return \App\Models\Medicine::query()
                                                ->select('id', 'name', 'brand', 'dosage')
                                                ->whereRaw("CONCAT(brand, ' ', name, ' ', dosage) LIKE ?", ["%{$search}%"])
                                                ->limit(10)
                                                ->get()
                                                ->mapWithKeys(fn($item) => [
                                                    $item->id => "{$item->brand} / {$item->name} / {$item->form} / {$item->dosage}"
                                                ])
                                                ->toArray();
                                        })
                                        ->afterStateUpdated(function ($set, Get $get) {
                                            $dosage = $get('medicine_id') ? Medicine::find($get('medicine_id'))?->dosage : '';
                                            $set('dosage', $dosage);
                                        })
                                        ->preload()
                                        ->optionsLimit(10)
                                        ->columnSpan(3)
                                        ->getOptionLabelFromRecordUsing(fn($record) => "{$record->brand} / {$record->name} / {$record->form} / {$record->dosage}")
                                        ->reactive(),
                                    Forms\Components\Toggle::make('is_qsp')
                                        ->columnSpan(1)
                                        ->inline(false)
                                        ->required()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('quantity')
                                        ->columnSpan(1)
                                        ->numeric()
                                        ->required(),
                                    Forms\Components\Hidden::make('dosage'),
                                    Forms\Components\TextInput::make('unit')
                                        ->columnSpan(1)
                                        ->required()
                                        ->maxLength(255)
                                        ->hidden(fn(Get $get) => $get('is_qsp')),
                                    Forms\Components\Select::make('unit')
                                        ->options(['days' => 'days', 'months' => 'months', 'weeks' => 'weeks',])
                                        ->columnSpan(1)
                                        ->required()
                                        ->hidden(fn(Get $get) => !$get('is_qsp')),
                                    Forms\Components\TextInput::make('qte')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Select::make('form')
                                        ->options(function (Get $get) {
                                            $medicine = Medicine::find($get('medicine_id'));
                                            if (!$medicine) {
                                                return [];
                                            }
                                            $notations = FormModel::where('form', $medicine->form)->first()?->notations ?? [];
                                            // Ensure $notations is always an array
                                            if (is_string($notations)) {
                                                $notations = explode(',', $notations);
                                            }
                                            if (!is_array($notations)) {
                                                $notations = [];
                                            }
                                            // Return as associative array for Filament Select
                                            return collect($notations)
                                                ->mapWithKeys(fn($item) => [$item => $item])
                                                ->toArray();
                                        })
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('frequency')
                                        ->columnSpan(1)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Select::make('periodicity')
                                        ->options(['day' => 'day', 'month' => 'month', 'week' => 'week',])
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TagsInput::make('conditions')
                                        ->columnSpan(2)
                                        ->separator(','),
                                ])
                                ->columns(3)
                                ->columnSpanFull()
                                ->reorderable(true),

                        ]),
                ])
                    ->columnSpanFull()
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
                        Infolists\Components\TextEntry::make('patient.user.firstname')
                            ->label('First Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.user.lastname')
                            ->label('Last Name')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.user.birthdate')
                            ->label('Birthdate')
                            ->inlineLabel(true)
                            ->date()
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.user.phone_number')
                            ->label('Phone Number')
                            ->inlineLabel(true)
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.user.blood_type')
                            ->inlineLabel(true)
                            ->label('Blood Type')
                            ->columnSpan(1),
                        Infolists\Components\TextEntry::make('patient.user.gender')
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
