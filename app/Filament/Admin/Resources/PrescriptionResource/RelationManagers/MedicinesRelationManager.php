<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;
use App\Models\Medicine;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicinesRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptionMedicines';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Select::make('medicine_id')
                            ->relationship('medicine', 'name')
                            ->required()
                            ->searchable(['name', 'brand', 'dosage'])
                            ->getSearchResultsUsing(function (string $search) {
                                return Medicine::query()
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
                        Toggle::make('is_qsp')
                            ->columnSpan(1)
                            ->inline(false)
                            ->required()
                            ->reactive(),
                        TextInput::make('quantity')
                            ->columnSpan(1)
                            ->numeric()
                            ->required(),
                        Hidden::make('dosage'),
                        Hidden::make('unit'),
                        TextInput::make('unit_text')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255)
                            ->hidden(fn(Get $get) => $get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        Select::make('unit_select')
                            ->options(['days' => 'days', 'months' => 'months', 'weeks' => 'weeks',])
                            ->columnSpan(1)
                            ->required()
                            ->hidden(fn(Get $get) => !$get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        TextInput::make('qte')
                            ->numeric()
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('form')
                            ->datalist(function (Get $get) {
                                $medicine = Medicine::find($get('recordId'));
                                if (!$medicine) {
                                    return [];
                                }

                                $notations = FormModel::where('form', $medicine->form)->first()?->notations ?? [];

                                if (is_string($notations)) {
                                    $notations = explode(',', $notations);
                                }
                                if (!is_array($notations)) {
                                    $notations = [];
                                }

                                return collect($notations)
                                    ->mapWithKeys(fn($item) => [$item => $item])
                                    ->toArray();
                            })
                            ->columnSpan(1)
                            ->required(),

                        TextInput::make('frequency')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        Select::make('periodicity')
                            ->options(['day' => 'day', 'month' => 'month', 'week' => 'week',])
                            ->columnSpan(1)
                            ->required(),
                        TagsInput::make('conditions')
                            ->columnSpan(2)
                            ->separator(','),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('medicine.name')
                    ->label(__('interface.name')),
                TextColumn::make('medicine.brand')
                    ->label(__('interface.brand')),
                TextColumn::make('form')
                    ->label(__('interface.form')),
                TextColumn::make('dosage')
                    ->label(__('interface.dosage')),
                TextColumn::make('quantity')
                    ->label(__('interface.quantity')),
                TextColumn::make('unit')
                    ->label(__('interface.unit')),
                TextColumn::make('qte')
                    ->label(__('interface.quantity')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                CreateAction::make()
            ])
            ->recordActions([
                // ...
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // ...
                    DetachBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
