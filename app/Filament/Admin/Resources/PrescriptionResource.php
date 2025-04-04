<?php

namespace App\Filament\Admin\Resources;

use Carbon\Carbon;
use App\Filament\Admin\Resources\PrescriptionResource\Pages;
use App\Filament\Admin\Resources\PrescriptionResource\RelationManagers;
use App\Forms\Components\PatientForm;
use App\Models\Prescription;
use Filament\Forms;
use Filament\Forms\Form;
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
                                        ->searchable(['name', 'brand'])
                                        ->preload()
                                        ->optionsLimit(10)
                                        ->columnSpan(3),
                                    Forms\Components\Toggle::make('is_qsp')
                                        ->columnSpan(1)
                                        ->inline(false)
                                        ->required(),
                                    Forms\Components\TextInput::make('quantity')
                                        ->columnSpan(1)
                                        ->numeric()
                                        ->required(),
                                    Forms\Components\TextInput::make('unit')
                                        ->columnSpan(1)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('posology')
                                        ->columnSpan(1)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TagsInput::make('conditions')
                                        ->columnSpan(2)
                                        ->required()
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
                    ->icon('heroicon-o-document-download')
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
