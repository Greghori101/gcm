<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\RelationManagers;

use App\Models\Medicine;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicinesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicines';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('interface.name')),
                Tables\Columns\TextColumn::make('brand')
                    ->label(__('interface.brand')),
                Tables\Columns\TextColumn::make('form')
                    ->label(__('interface.form')),
                Tables\Columns\TextColumn::make('dosage')
                    ->label(__('interface.dosage')),
                Tables\Columns\TextColumn::make('pivot.quantity')
                    ->label(__('interface.quantity')),
                Tables\Columns\TextColumn::make('pivot.unit')
                    ->label(__('interface.unit')),
                Tables\Columns\TextColumn::make('pivot.qte')
                    ->label(__('interface.quantity')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                Tables\Actions\AttachAction::make()
                    ->form(fn(Tables\Actions\AttachAction $action): array => [

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
                            ->options(['days', 'months', 'weeks',])
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
                            ->options(['day', 'month', 'week',])
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\TagsInput::make('conditions')
                            ->columnSpan(2)
                            ->separator(','),


                    ])
            ])
            ->actions([
                // ...
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // ...
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
