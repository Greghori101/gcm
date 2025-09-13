<?php

namespace App\Filament\Admin\Resources\PatientResource\RelationManagers;

use App\Models\Medicine;
use App\Models\Form as FormModel;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('prescriptionMedicines')
                    ->relationship()
                    ->cloneable()
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
                        Forms\Components\Hidden::make('unit'),
                        Forms\Components\TextInput::make('unit_text')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255)
                            ->hidden(fn(Get $get) => $get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        Forms\Components\Select::make('unit_select')
                            ->options(['days' => 'days', 'months' => 'months', 'weeks' => 'weeks',])
                            ->columnSpan(1)
                            ->required()
                            ->hidden(fn(Get $get) => !$get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        Forms\Components\TextInput::make('qte')
                            ->numeric()
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('form')
                            ->datalist(function (Get $get) {
                                $medicine = Medicine::find($get('medicine_id'));
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


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nb')
            ->columns([
                Tables\Columns\TextColumn::make('nb'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->authorize(true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->authorize(true),
                Tables\Actions\EditAction::make()->authorize(true),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
